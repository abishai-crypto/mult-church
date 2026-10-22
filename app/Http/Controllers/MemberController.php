<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Member;
use App\Services\AuditService;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('departments');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('membership_status', $request->status);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('baptism')) {
            $query->where('baptism_status', $request->baptism);
        }

        $members = $query->orderBy('first_name')->paginate(12)->withQueryString();

        $totalMembers = Member::count();
        $activeMembers = Member::where('membership_status', 'Active')->count();
        $baptizedMembers = Member::where('baptism_status', 'Baptized')->count();

        return view('members.index', compact(
            'members',
            'totalMembers',
            'activeMembers',
            'baptizedMembers'
        ));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('members.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'residential_address' => 'nullable|string|max:500',
            'occupation' => 'nullable|string|max:100',
            'baptism_status' => 'required|in:Baptized,Not Baptized',
            'baptism_date' => 'nullable|date',
            'membership_status' => 'required|in:Active,Inactive,Transferred,Deceased',
            'joined_date' => 'nullable|date',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:30',
            'notes' => 'nullable|string',
            'departments' => 'nullable|array',
        ]);

        $nextNum = Member::count() + 1;
        $memberNumber = 'MBR-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        $member = Member::create(array_merge($validated, [
            'member_number' => $memberNumber,
        ]));

        if (!empty($validated['departments'])) {
            foreach ($validated['departments'] as $deptId) {
                $member->departments()->attach($deptId, [
                    'church_id' => $member->church_id,
                    'role_in_department' => 'Member',
                    'joined_at' => now(),
                    'is_active' => true,
                ]);
            }
        }

        AuditService::log('created', "Added new church member {$member->full_name} ({$member->member_number})", 'Member', $member->id);

        // Tuma SMS ya kumkaribisha mshirika rasmi kanisani
        if ($member->phone) {
            $churchName = $member->church?->name ?? 'EAGT Golani';
            $msg = "Bwana Asifiwe {$member->first_name}! Karibu rasmi kwenye usharika wa {$churchName}. Nambari yako ya ushirika ni {$member->member_number}. Mungu akubariki sana unapoendelea kukua kiroho pamoja nasi!";
            \App\Services\SmsService::send($member->phone, $msg, $member->church_id);
        }

        return redirect()->route('members.show', $member)->with('success', "Mshirika '{$member->full_name}' amesajiliwa kikamilifu na ametumiwa SMS ya ukaribisho.");
    }

    public function show(Member $member)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $isMember = $user ? $user->isMember() : false;
        $isTreasurer = $user ? $user->isTreasurer() : false;

        $member->load([
            'departments',
            'financialTransactions' => function ($q) use ($isMember, $isTreasurer) {
                if ($isMember) {
                    $q->whereIn('category', ['building_offering', 'special_contribution', 'other_income']);
                } elseif ($isTreasurer) {
                    $q->where('category', '!=', 'tithe');
                }
                $q->latest()->take(10);
            },
            'pastoralVisits' => fn($q) => $q->with('pastor')->latest('visit_date'),
            'prayerRequests' => fn($q) => $q->latest(),
        ]);

        $givingQuery = $member->financialTransactions()->where('status', 'confirmed');
        if ($isMember) {
            $givingQuery->whereIn('category', ['building_offering', 'special_contribution', 'other_income']);
        } elseif ($isTreasurer) {
            $givingQuery->where('category', '!=', 'tithe');
        }
        $totalGiving = $givingQuery->sum('amount');

        return view('members.show', compact('member', 'totalGiving', 'isMember'));
    }

    public function edit(Member $member)
    {
        $departments = Department::where('is_active', true)->get();
        $memberDeptIds = $member->departments()->pluck('departments.id')->toArray();

        return view('members.edit', compact('member', 'departments', 'memberDeptIds'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'residential_address' => 'nullable|string|max:500',
            'occupation' => 'nullable|string|max:100',
            'baptism_status' => 'required|in:Baptized,Not Baptized',
            'baptism_date' => 'nullable|date',
            'membership_status' => 'required|in:Active,Inactive,Transferred,Deceased',
            'joined_date' => 'nullable|date',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:30',
            'notes' => 'nullable|string',
            'departments' => 'nullable|array',
        ]);

        $member->update($validated);

        if (isset($validated['departments'])) {
            $syncData = [];
            foreach ($validated['departments'] as $deptId) {
                $syncData[$deptId] = ['church_id' => $member->church_id, 'is_active' => true];
            }
            $member->departments()->sync($syncData);
        }

        AuditService::log('updated', "Updated profile for member {$member->full_name}", 'Member', $member->id);

        return redirect()->route('members.show', $member)->with('success', "Member '{$member->full_name}' updated successfully.");
    }

    public function destroy(Member $member)
    {
        $name = $member->full_name;
        $member->delete();

        AuditService::log('deleted', "Deleted member {$name}", 'Member', $member->id);

        return redirect()->route('members.index')->with('success', "Member '{$name}' removed.");
    }

    /**
     * Export members list to CSV (Excel compatible).
     */
    public function exportCsv(Request $request)
    {
        $query = Member::with('departments');

        if ($request->filled('status')) {
            $query->where('membership_status', $request->status);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('baptism')) {
            $query->where('baptism_status', $request->baptism);
        }

        $members = $query->orderBy('first_name')->get();
        $filename = 'orodha_ya_waumini_' . date('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($members) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($file, [
                'Namba ya Ushirika',
                'Jina Kamili',
                'Jinsia',
                'Tarehe ya Kuzaliwa',
                'Hali ya Ndoa',
                'Namba ya Simu',
                'Barua Pepe',
                'Makazi / Mtaa',
                'Kazi / Taaluma',
                'Ubatizo',
                'Hali ya Ushirika',
                'Tarehe ya Kujiunga',
                'Idara',
            ]);

            foreach ($members as $m) {
                fputcsv($file, [
                    $m->member_number,
                    $m->full_name,
                    $m->gender,
                    $m->date_of_birth ? $m->date_of_birth->format('Y-m-d') : '-',
                    $m->marital_status,
                    $m->phone,
                    $m->email,
                    $m->residential_address,
                    $m->occupation,
                    $m->baptism_status,
                    $m->membership_status,
                    $m->joined_date ? $m->joined_date->format('Y-m-d') : '-',
                    $m->departments->pluck('name')->implode(', '),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Print-ready official church member directory.
     */
    public function printDirectory(Request $request)
    {
        $church = \Illuminate\Support\Facades\Auth::user()->church;
        $query = Member::with('departments');

        if ($request->filled('status')) {
            $query->where('membership_status', $request->status);
        }

        $members = $query->orderBy('first_name')->get();

        return view('members.directory_print', compact('church', 'members'));
    }
}
