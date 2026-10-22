<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Church;
use App\Models\Department;
use App\Models\Event;
use App\Models\PrayerRequest;
use App\Models\Project;
use App\Models\Service;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $church = Church::where('slug', 'eagt-golani')->first() ?? Church::first();

        if (!$church) {
            return redirect()->route('login');
        }

        $services = Service::where('church_id', $church->id)
            ->where('is_active', true)
            ->get();

        $departments = Department::where('church_id', $church->id)
            ->where('is_active', true)
            ->get();

        $projects = Project::where('church_id', $church->id)
            ->latest()
            ->take(3)
            ->get();

        $video = YoutubeVideo::where('church_id', $church->id)
            ->latest()
            ->first();

        $announcements = Announcement::where('church_id', $church->id)
            ->latest()
            ->take(3)
            ->get();

        $upcomingEvents = Event::where('church_id', $church->id)
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take(3)
            ->get();

        $testimonies = PrayerRequest::where('church_id', $church->id)
            ->where('status', 'answered')
            ->whereNotNull('testimony')
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact(
            'church',
            'services',
            'departments',
            'projects',
            'video',
            'announcements',
            'upcomingEvents',
            'testimonies'
        ));
    }

    public function submitPrayer(Request $request)
    {
        $validated = $request->validate([
            'requester_name' => 'required|string|max:255',
            'requester_phone' => 'nullable|string|max:50',
            'category' => 'required|string',
            'request_text' => 'required|string',
            'is_confidential' => 'nullable|boolean',
        ]);

        $church = Church::where('slug', 'eagt-golani')->first() ?? Church::first();

        PrayerRequest::create([
            'church_id' => $church ? $church->id : 1,
            'requester_name' => $validated['requester_name'],
            'requester_phone' => $validated['requester_phone'] ?? null,
            'category' => $validated['category'],
            'request_text' => $validated['request_text'],
            'is_confidential' => $request->has('is_confidential'),
            'status' => 'pending',
        ]);

        return back()->with('prayer_success', 'Bwana Asifiwe! Ombi lako la maombi limepokelewa salama na limekabidhiwa kwa Mchungaji Kiongozi na Wazee wa Kanisa kwa ajili ya maombezi.');
    }

    /**
     * Process online giving (Zaka na Sadaka Mtandaoni).
     */
    public function giveOnline(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:150',
            'phone' => 'required|string|max:30',
            'category' => 'required|in:tithe,regular_offering,thanksgiving,building_offering,special_contribution',
            'amount' => 'required|numeric|min:500',
            'payment_method' => 'required|string',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ], [
            'donor_name.required' => 'Tafadhali weka jina lako kamili.',
            'phone.required' => 'Tafadhali weka namba yako ya simu.',
            'amount.min' => 'Kiasi cha chini cha sadaka ni Tsh 500.',
        ]);

        $church = Church::where('slug', 'eagt-golani')->first() ?? Church::first();
        $churchId = $church ? $church->id : 1;

        // Angalia kama mtoaji ni mshirika aliyesajiliwa kwa namba ya simu
        $cleanedPhone = \App\Services\SmsService::formatTanzanianPhone($validated['phone']);
        $member = \App\Models\Member::where('church_id', $churchId)
            ->where(function ($q) use ($validated, $cleanedPhone) {
                $q->where('phone', $validated['phone'])
                  ->orWhere('phone', $cleanedPhone)
                  ->orWhere('phone', 'like', '%' . substr($validated['phone'], -9));
            })->first();

        $txnCode = 'TXN-ONL-' . strtoupper(\Illuminate\Support\Str::random(6));

        $adminUser = \App\Models\User::where('church_id', $churchId)->whereIn('role', ['church_admin', 'super_admin'])->first()
            ?? \App\Models\User::first();

        $transaction = \App\Models\FinancialTransaction::create([
            'church_id' => $churchId,
            'transaction_code' => $txnCode,
            'member_id' => $member?->id,
            'donor_name' => $validated['donor_name'],
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'currency' => 'TZS',
            'payment_method' => $validated['payment_method'],
            'reference_number' => $validated['reference_number'] ?? ('PUSH-' . rand(100000, 999999)),
            'transaction_date' => now()->format('Y-m-d'),
            'notes' => $validated['notes'] ?? 'Sadaka/Zaka iliyotolewa mtandaoni kupitia Tovuti ya Kanisa',
            'status' => 'pending',
            'entered_by' => $adminUser ? $adminUser->id : 1,
        ]);

        \App\Services\AuditService::log(
            'created',
            "Mchango mpya wa mtandaoni: Tsh " . number_format($transaction->amount) . " kutoka kwa {$validated['donor_name']} ({$txnCode})",
            'FinancialTransaction',
            $transaction->id,
            null,
            null,
            $churchId
        );

        // Tuma notisi kwa watunza hazina na wachungaji
        \App\Services\AuditService::notifyRole(
            $churchId,
            ['pastor', 'treasurer', 'elder', 'church_admin'],
            'Sadaka Mpya ya Mtandaoni',
            "Kuna mchango mpya mtandaoni wa Tsh " . number_format($transaction->amount) . " kutoka kwa {$validated['donor_name']} unaosubiri kuthibitishwa.",
            'info',
            route('finances.index')
        );

        // Tuma SMS ya uthibitisho kwa mtoaji
        $churchName = $church?->name ?? 'EAGT Golani';
        $categoryLabel = match($validated['category']) {
            'tithe' => 'Zaka',
            'building_offering' => 'Sadaka ya Ujenzi',
            'thanksgiving' => 'Sadaka ya Shukrani',
            default => 'Sadaka',
        };

        $smsMsg = "Bwana Asifiwe {$validated['donor_name']}! Ahsante kwa kutoa {$categoryLabel} ya Tsh " . number_format($validated['amount']) . " kwa njia ya mtandao (Kumb: {$txnCode}). Uongozi wa {$churchName} unathibitisha kupokea. Mungu akubariki sana!";
        \App\Services\SmsService::send($validated['phone'], $smsMsg, $churchId);

        return back()->with('giving_success', [
            'code' => $txnCode,
            'amount' => $validated['amount'],
            'donor' => $validated['donor_name'],
            'category' => $categoryLabel,
            'method' => strtoupper($validated['payment_method']),
        ]);
    }
}
