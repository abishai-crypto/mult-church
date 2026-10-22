<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\PastoralVisit;
use App\Models\PrayerRequest;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PastoralCareController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastoral Visits
        $visits = PastoralVisit::with(['member', 'pastor'])
            ->latest('visit_date')
            ->paginate(10);

        // Prayer Requests query
        $prayerQuery = PrayerRequest::with('member');

        // Only Pastor, Elder, Church Admin, or Super Admin can see confidential requests!
        if (!$user->isPastor() && !$user->isElder()) {
            $prayerQuery->where('is_confidential', false);
        }

        $prayerRequests = $prayerQuery->latest()->paginate(10);

        $members = Member::where('membership_status', 'Active')->orderBy('first_name')->get();

        $pendingPrayers = PrayerRequest::where('status', 'pending')->count();
        $prayingCount = PrayerRequest::where('status', 'praying')->count();
        $answeredPrayers = PrayerRequest::where('status', 'answered')->count();

        return view('pastoral.index', compact(
            'visits',
            'prayerRequests',
            'members',
            'pendingPrayers',
            'prayingCount',
            'answeredPrayers'
        ));
    }

    public function storeVisit(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'visit_date' => 'required|date',
            'visit_type' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'follow_up_required' => 'nullable|boolean',
            'follow_up_date' => 'nullable|date',
        ]);

        $visit = PastoralVisit::create(array_merge($validated, [
            'pastor_id' => Auth::id(),
            'follow_up_required' => $request->has('follow_up_required'),
        ]));

        $memberName = Member::find($validated['member_id'])?->full_name;
        AuditService::log('created', "Logged {$visit->visit_type} with {$memberName}", 'PastoralVisit', $visit->id);

        return back()->with('success', "Pastoral visit with {$memberName} recorded.");
    }

    public function storePrayer(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'requester_name' => 'required|string|max:100',
            'requester_phone' => 'nullable|string|max:30',
            'category' => 'required|string|max:50',
            'request_text' => 'required|string',
            'is_confidential' => 'nullable|boolean',
        ]);

        $prayer = PrayerRequest::create(array_merge($validated, [
            'status' => 'pending',
            'is_confidential' => $request->has('is_confidential'),
        ]));

        $confidentialNotice = $prayer->is_confidential ? ' (CONFIDENTIAL)' : '';
        AuditService::log('created', "Submitted prayer request for {$prayer->requester_name}{$confidentialNotice}", 'PrayerRequest', $prayer->id);

        return back()->with('success', "Prayer request submitted. Our pastoral team is interceding with you!");
    }

    public function updatePrayerStatus(Request $request, PrayerRequest $prayerRequest)
    {
        $user = Auth::user();

        if (!$user->isPastor() && !$user->isElder()) {
            abort(403, 'Only Pastors or Elders can update prayer request status.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,praying,answered',
            'pastoral_notes' => 'nullable|string',
            'testimony' => 'nullable|string',
        ]);

        $prayerRequest->update($validated);

        AuditService::log('updated', "Updated prayer request #{$prayerRequest->id} to '{$prayerRequest->status}'", 'PrayerRequest', $prayerRequest->id);

        return back()->with('success', "Prayer request updated to '{$prayerRequest->status}'.");
    }
}
