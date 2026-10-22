<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentFinance;
use App\Models\DepartmentMember;
use App\Models\Member;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('departmentMembers')->get();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader_name' => 'nullable|string|max:255',
            'leader_phone' => 'nullable|string|max:50',
            'meeting_day' => 'nullable|string|max:50',
            'meeting_time' => 'nullable|string|max:20',
            'banner_color' => 'required|string|max:20',
        ]);

        $slug = Str::slug($validated['name']);

        $department = Department::create(array_merge($validated, [
            'slug' => $slug,
            'is_active' => true,
        ]));

        AuditService::log('created', "Created department '{$department->name}'", 'Department', $department->id);

        return redirect()->route('departments.show', $department)->with('success', "Department '{$department->name}' created.");
    }

    public function show(Department $department)
    {
        $department->load([
            'departmentMembers.member',
            'finances.recorder',
            'events',
            'announcements',
        ]);

        $allMembers = Member::where('membership_status', 'Active')->orderBy('first_name')->get();

        $totalIncome = $department->totalIncome();
        $totalExpense = $department->totalExpense();
        $balance = $department->balance();

        return view('departments.show', compact('department', 'allMembers', 'totalIncome', 'totalExpense', 'balance'));
    }

    public function addMember(Request $request, Department $department)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'role_in_department' => 'required|string|max:50',
        ]);

        $exists = DepartmentMember::where('department_id', $department->id)
            ->where('member_id', $validated['member_id'])
            ->first();

        if ($exists) {
            $exists->update([
                'role_in_department' => $validated['role_in_department'],
                'is_active' => true,
            ]);
            return back()->with('info', "Updated member role in {$department->name}.");
        }

        DepartmentMember::create([
            'church_id' => $department->church_id,
            'department_id' => $department->id,
            'member_id' => $validated['member_id'],
            'role_in_department' => $validated['role_in_department'],
            'joined_at' => now(),
            'is_active' => true,
        ]);

        $memberName = Member::find($validated['member_id'])?->full_name;
        AuditService::log('created', "Enrolled {$memberName} into {$department->name} as {$validated['role_in_department']}", 'DepartmentMember', $department->id);

        return back()->with('success', "{$memberName} added to {$department->name}!");
    }

    public function removeMember(Department $department, Member $member)
    {
        DepartmentMember::where('department_id', $department->id)
            ->where('member_id', $member->id)
            ->delete();

        AuditService::log('deleted', "Removed {$member->full_name} from {$department->name}", 'DepartmentMember', $department->id);

        return back()->with('success', "{$member->full_name} removed from department.");
    }

    public function storeFinance(Request $request, Department $department)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'payment_method' => 'required|string|max:30',
            'reference_number' => 'nullable|string|max:100',
            'member_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $finance = DepartmentFinance::create(array_merge($validated, [
            'church_id' => $department->church_id,
            'department_id' => $department->id,
            'currency' => 'USD',
            'recorded_by' => Auth::id(),
        ]));

        AuditService::log('created', "Logged {$finance->type} of \${$finance->amount} for {$department->name}", 'DepartmentFinance', $finance->id);

        return back()->with('success', "Department {$finance->type} of \${$finance->amount} recorded.");
    }
}
