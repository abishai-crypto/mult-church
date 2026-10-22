<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Member;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmsController extends Controller
{
    public function index()
    {
        $church = Auth::user()->church;
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $membersCount = Member::where('membership_status', 'Active')->whereNotNull('phone')->count();

        // Recent SMS audit logs
        $recentSms = AuditLog::where('action', 'sent_sms')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        return view('sms.index', compact('departments', 'membersCount', 'recentSms', 'church'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'target_type' => 'required|in:all_members,department,custom',
            'message' => 'required|string|max:480',
            'department_id' => 'required_if:target_type,department',
            'custom_phone' => 'required_if:target_type,custom',
        ], [
            'message.required' => 'Tafadhali andika ujumbe wa SMS unaotaka kutuma.',
            'message.max' => 'Ujumbe hauwezi kuzidi herufi 480 (takriban SMS 3).',
        ]);

        $church = Auth::user()->church;
        $churchId = $church?->id;
        $recipients = [];

        if ($request->target_type === 'all_members') {
            $recipients = Member::where('membership_status', 'Active')
                ->whereNotNull('phone')
                ->pluck('phone')
                ->toArray();
        } elseif ($request->target_type === 'department') {
            $dept = Department::findOrFail($request->department_id);
            $recipients = $dept->members()
                ->where('department_members.is_active', true)
                ->whereNotNull('phone')
                ->pluck('phone')
                ->toArray();
        } elseif ($request->target_type === 'custom') {
            $rawPhones = explode(',', $request->custom_phone);
            foreach ($rawPhones as $p) {
                if (trim($p)) {
                    $recipients[] = trim($p);
                }
            }
        }

        if (empty($recipients)) {
            return back()->with('error', 'Hakuna namba za simu zilizopatikana kwa kundi ulilochagua.');
        }

        $result = SmsService::send($recipients, $request->message, $churchId);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }
}
