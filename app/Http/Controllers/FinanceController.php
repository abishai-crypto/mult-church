<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\FinancialTransaction;
use App\Models\Member;
use App\Models\Service;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isMember = $user->isMember();
        $isTreasurer = $user->isTreasurer();

        // Miamala inayosubiri uthibitisho (Pending transactions)
        $pendingQuery = FinancialTransaction::with(['member', 'service', 'enteredBy'])
            ->where('status', 'pending');

        if ($isMember) {
            // Mshirika haoni miamala ya kanisa zima inayosubiri kibali cha wazee
            // Anaona michango yake mwenyewe ya ujenzi inayosubiri uthibitisho
            $pendingQuery->where(function ($q) use ($user) {
                if ($user->member_id) {
                    $q->where('member_id', $user->member_id);
                } else {
                    $q->where('entered_by', $user->id);
                }
            })->whereIn('category', ['building_offering', 'special_contribution', 'other_income']);
        }

        $pendingTransactions = $pendingQuery->orderBy('transaction_date', 'desc')->get();

        // Miamala iliyothibitishwa (Confirmed ledger)
        $confirmedQuery = FinancialTransaction::with(['member', 'service', 'enteredBy', 'approvedBy'])
            ->where('status', 'confirmed');

        // SHERIA YA KANISA:
        // 1. Mshirika asione Sadaka za kawaida, Zaka na Shukrani! Aone michango ya ujenzi, miradi na matumizi pekee.
        // 2. Mhazini haruhusiwi kuona Zaka zilizothibitishwa (zinaenda kwa Mchungaji Kiongozi).
        // 3. Wazee wa Kanisa na Mchungaji pekee ndio wanaoona Zaka na Sadaka zote.
        if ($isMember) {
            $confirmedQuery->whereIn('category', ['building_offering', 'special_contribution', 'other_income']);
        } elseif ($isTreasurer) {
            $confirmedQuery->where('category', '!=', 'tithe');
        }

        if ($request->filled('category')) {
            if ($isMember && !in_array($request->category, ['building_offering', 'special_contribution', 'other_income'])) {
                $confirmedQuery->whereRaw('1 = 0');
            } elseif ($isTreasurer && $request->category === 'tithe') {
                $confirmedQuery->whereRaw('1 = 0');
            } else {
                $confirmedQuery->where('category', $request->category);
            }
        }

        if ($request->filled('payment_method')) {
            $confirmedQuery->where('payment_method', $request->payment_method);
        }

        if ($request->filled('from_date')) {
            $confirmedQuery->where('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $confirmedQuery->where('transaction_date', '<=', $request->to_date);
        }

        $confirmedTransactions = $confirmedQuery->orderBy('transaction_date', 'desc')->paginate(15)->withQueryString();

        // Takwimu za Kifedha (Statistics)
        if ($isMember) {
            // Mshirika anaona michango ya ujenzi na miradi pekee
            $totalConfirmed = FinancialTransaction::where('status', 'confirmed')
                ->whereIn('category', ['building_offering', 'special_contribution', 'other_income'])
                ->sum('amount');
            $totalTithes = null;
            $totalRegularOfferings = null;
        } elseif ($isTreasurer) {
            // Mhazini anaona jumla ya sadaka na michango bila Zaka
            $totalConfirmed = FinancialTransaction::where('status', 'confirmed')
                ->where('category', '!=', 'tithe')
                ->sum('amount');
            $totalTithes = null; // Imefichwa kwa Mhazini
            $totalRegularOfferings = FinancialTransaction::where('status', 'confirmed')->where('category', 'regular_offering')->sum('amount');
        } else {
            // Mchungaji, Wazee wa Kanisa na Admins wanaona yote ikiwemo Zaka na Sadaka
            $totalConfirmed = FinancialTransaction::where('status', 'confirmed')->sum('amount');
            $totalTithes = FinancialTransaction::where('status', 'confirmed')->where('category', 'tithe')->sum('amount');
            $totalRegularOfferings = FinancialTransaction::where('status', 'confirmed')->where('category', 'regular_offering')->sum('amount');
        }

        $totalPending = $pendingTransactions->sum('amount');
        $totalBuilding = FinancialTransaction::where('status', 'confirmed')->where('category', 'building_offering')->sum('amount');
        $totalExpenses = Expense::where('status', 'approved')->sum('amount');

        return view('finances.index', compact(
            'pendingTransactions',
            'confirmedTransactions',
            'totalConfirmed',
            'totalPending',
            'totalTithes',
            'totalRegularOfferings',
            'totalBuilding',
            'totalExpenses',
            'isTreasurer',
            'isMember'
        ));
    }

    public function create()
    {
        $user = Auth::user();
        $isMember = $user->isMember();
        $members = Member::where('membership_status', 'Active')->orderBy('first_name')->get();
        $services = Service::where('is_active', true)->get();

        return view('finances.create', compact('members', 'services', 'isMember'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Kama ni mshirika wa kawaida, anaruhusiwa kuwasilisha michango ya ujenzi na miradi pekee
        if ($user->isMember()) {
            $validated = $request->validate([
                'category' => 'required|in:building_offering,special_contribution,other_income',
                'amount' => 'required|numeric|min:1',
                'donor_name' => 'nullable|string|max:255',
                'payment_method' => 'required|in:cash,bank_transfer,mobile_money,cheque,card',
                'reference_number' => 'nullable|string|max:100',
                'transaction_date' => 'required|date',
                'notes' => 'nullable|string',
            ], [
                'category.in' => 'Kama mshirika, unaruhusiwa kutoa mchango wa ujenzi na miradi pekee. Zaka na sadaka za ibada zinapokelewa na kusimamiwa na Wazee wa Kanisa na Mchungaji.',
            ]);

            $transaction = FinancialTransaction::create(array_merge($validated, [
                'status' => 'pending',
                'entered_by' => $user->id,
                'member_id' => $user->member_id,
                'currency' => 'TZS',
            ]));

            AuditService::log(
                'created',
                "Mshirika ({$user->name}) amewasilisha mchango wa ujenzi wa Tsh " . number_format($transaction->amount) . " (Nambari: {$transaction->transaction_code}) unaosubiri uthibitisho",
                'FinancialTransaction',
                $transaction->id
            );

            AuditService::notifyRole(
                $transaction->church_id,
                ['pastor', 'elder', 'treasurer'],
                'Mchango Mpya wa Ujenzi',
                "Mshirika {$user->name} amewasilisha mchango wa ujenzi wa Tsh " . number_format($transaction->amount) . " unaongoja uthibitisho.",
                'info',
                route('finances.index')
            );

            return redirect()->route('finances.index')->with('success', "Mchango wako wa Ujenzi wa Tsh " . number_format($transaction->amount) . " umepokelewa salama na unangoja kuthibitishwa na Wazee wa Kanisa. Mungu akubariki sana!");
        }

        $validated = $request->validate([
            'category' => 'required|in:tithe,regular_offering,thanksgiving,building_offering,special_contribution,other_income',
            'amount' => 'required|numeric|min:1',
            'member_id' => 'nullable|exists:members,id',
            'donor_name' => 'nullable|string|max:255',
            'service_id' => 'nullable|exists:services,id',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,cheque,card',
            'reference_number' => 'nullable|string|max:100',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $transaction = FinancialTransaction::create(array_merge($validated, [
            'status' => 'pending',
            'entered_by' => Auth::id(),
            'currency' => 'TZS',
        ]));

        $categoryName = $transaction->category === 'tithe' ? 'Zaka' : 'Sadaka';
        AuditService::log(
            'created',
            "Kuingiza muamala wa {$categoryName} ya Tsh " . number_format($transaction->amount) . " (Nambari: {$transaction->transaction_code}) unaosubiri uthibitisho",
            'FinancialTransaction',
            $transaction->id
        );

        // Notisi kwa Mchungaji na Wazee wa Kanisa
        $message = $transaction->category === 'tithe'
            ? "Kuna Zaka ya Tsh " . number_format($transaction->amount) . " imeingizwa na inasubiri uthibitisho wa Wazee wa Kanisa ili ikabidhiwe kwa Mchungaji."
            : "Kuna Sadaka mpya ya Tsh " . number_format($transaction->amount) . " inasubiri uthibitisho.";

        AuditService::notifyRole(
            $transaction->church_id,
            ['pastor', 'elder', 'church_admin'],
            'Uthibitisho wa Mapato ya Kanisa',
            $message,
            'warning',
            route('finances.index')
        );

        $successMsg = $transaction->category === 'tithe'
            ? "Zaka ya Tsh " . number_format($transaction->amount) . " imerekodiwa! Kwa mujibu wa taratibu za kanisa, inasubiri kuthibitishwa na Wazee wa Kanisa na itakabidhiwa moja kwa moja kwa Mchungaji Kiongozi."
            : "Muamala {$transaction->transaction_code} umerekodiwa na unangoja kuthibitishwa na Mchungaji au Mzee wa Kanisa.";

        return redirect()->route('finances.index')->with('success', $successMsg);
    }

    public function confirm(FinancialTransaction $transaction)
    {
        $user = Auth::user();

        // Dual control: Mchungaji, Mzee wa Kanisa au Admin
        if (!$user->isPastor() && !$user->isElder() && !$user->isChurchAdmin() && !$user->isSuperAdmin()) {
            abort(403, 'Ni Mchungaji au Mzee wa Kanisa aliyeidhinishwa pekee anayeweza kuthibitisha mapato.');
        }

        // Kuzuia mtu aliyeingiza kuthibitisha mwenyewe (Dual-control principle)
        if ($transaction->entered_by === $user->id && !$user->isSuperAdmin()) {
            return back()->withErrors(['error' => 'Usalama wa Mfumo (Dual-Control): Huwezi kuthibitisha muamala uliouingiza wewe mwenyewe. Mzee wa Kanisa mwingine au Mchungaji lazima athibitishe.']);
        }

        $transaction->update([
            'status' => 'confirmed',
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);

        // Tuma SMS ya risiti ya uthibitisho kama mshirika ana namba ya simu
        if ($transaction->member && $transaction->member->phone) {
            $churchName = $transaction->church?->name ?? 'EAGT Golani';
            $smsText = \App\Services\SmsService::titheReceipt(
                $transaction->member->first_name,
                (float) $transaction->amount,
                $transaction->transaction_code,
                $churchName
            );
            \App\Services\SmsService::send($transaction->member->phone, $smsText, $transaction->church_id);
        }

        $logMsg = $transaction->category === 'tithe'
            ? "Mzee wa Kanisa / Mchungaji ({$user->name}) amethibitisha Zaka ya Tsh " . number_format($transaction->amount) . " na kuikabidhi rasmi kwa Mchungaji Kiongozi."
            : "Kuthibitisha muamala wa {$transaction->transaction_code} wa Tsh " . number_format($transaction->amount);

        AuditService::log('approved', $logMsg, 'FinancialTransaction', $transaction->id);

        $returnMsg = $transaction->category === 'tithe'
            ? "Zaka ya Tsh " . number_format($transaction->amount) . " imethibitishwa rasmi na kukabidhiwa kwa Mchungaji Kiongozi! Mshirika ametumiwa SMS ya uthibitisho."
            : "Muamala {$transaction->transaction_code} umethibitishwa na kuingizwa rasmi kwenye leja kuu ya kanisa!";

        return back()->with('success', $returnMsg);
    }

    public function reverse(Request $request, FinancialTransaction $transaction)
    {
        $user = Auth::user();

        if (!$user->isPastor() && !$user->isElder() && !$user->isChurchAdmin()) {
            abort(403, 'Huna idhini ya kufuta au kurejesha muamala huu.');
        }

        $request->validate([
            'reversal_reason' => 'required|string|max:500',
        ]);

        $transaction->update([
            'status' => 'reversed',
            'reversed_by' => $user->id,
            'reversed_at' => now(),
            'reversal_reason' => $request->reversal_reason,
        ]);

        AuditService::log(
            'reversed',
            "Kufuta/Kurejesha muamala {$transaction->transaction_code} (Tsh " . number_format($transaction->amount) . "). Sababu: {$request->reversal_reason}",
            'FinancialTransaction',
            $transaction->id
        );

        return back()->with('warning', "Muamala {$transaction->transaction_code} umefutwa rasmi kwenye kumbukumbu.");
    }

    // Matumizi ya Kanisa (Expenses)
    public function expenses(Request $request)
    {
        $query = Expense::with(['enteredBy', 'approvedBy']);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $expenses = $query->orderBy('expense_date', 'desc')->paginate(15)->withQueryString();

        $totalApproved = Expense::where('status', 'approved')->sum('amount');
        $totalPending = Expense::where('status', 'pending')->sum('amount');

        return view('finances.expenses', compact('expenses', 'totalApproved', 'totalPending'));
    }

    public function createExpense()
    {
        return view('finances.create_expense');
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date',
            'payment_method' => 'required|string',
            'recipient_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $expense = Expense::create(array_merge($validated, [
            'status' => 'pending',
            'currency' => 'TZS',
            'entered_by' => Auth::id(),
        ]));

        AuditService::log('created', "Kurekodi matumizi: {$expense->title} (Tsh " . number_format($expense->amount) . ")", 'Expense', $expense->id);

        return redirect()->route('finances.expenses')->with('success', "Vocha ya matumizi {$expense->expense_code} imewasilishwa kwa ajili ya kibali cha uongozi.");
    }

    public function approveExpense(Expense $expense)
    {
        $user = Auth::user();

        if (!$user->isPastor() && !$user->isChurchAdmin()) {
            abort(403, 'Ni Mchungaji Kiongozi au Msimamizi wa Kanisa pekee anayeweza kuidhinisha matumizi.');
        }

        $expense->update([
            'status' => 'approved',
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);

        AuditService::log('approved', "Kuidhinisha vocha ya matumizi {$expense->expense_code} (Tsh " . number_format($expense->amount) . ")", 'Expense', $expense->id);

        return back()->with('success', "Matumizi ya Tsh " . number_format($expense->amount) . " yameidhinishwa kikamilifu!");
    }

    /**
     * Export church financial transactions as CSV file.
     */
    public function exportCsv(Request $request)
    {
        $user = Auth::user();
        $isMember = $user->isMember();
        $isTreasurer = $user->isTreasurer();

        $query = FinancialTransaction::with(['member', 'service', 'approvedBy'])
            ->where('status', 'confirmed');

        if ($isMember) {
            $query->whereIn('category', ['building_offering', 'special_contribution', 'other_income']);
        } elseif ($isTreasurer) {
            $query->where('category', '!=', 'tithe');
        }

        if ($request->filled('category')) {
            if ($isMember && !in_array($request->category, ['building_offering', 'special_contribution', 'other_income'])) {
                $query->whereRaw('1 = 0');
            } elseif ($isTreasurer && $request->category === 'tithe') {
                $query->whereRaw('1 = 0');
            } else {
                $query->where('category', $request->category);
            }
        }

        if ($request->filled('from_date')) {
            $query->where('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('transaction_date', '<=', $request->to_date);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();
        $filename = 'taarifa_ya_fedha_' . date('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Microsoft Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Kumbukumbu',
                'Tarehe',
                'Mtoa Sadaka / Muumini',
                'Aina ya Mchango',
                'Kiasi (Tsh)',
                'Njia ya Malipo',
                'Namba ya Muamala',
                'Aliyeidhinisha',
                'Hali',
            ]);

            foreach ($transactions as $txn) {
                fputcsv($file, [
                    $txn->transaction_code,
                    $txn->transaction_date->format('Y-m-d'),
                    $txn->member ? $txn->member->full_name : ($txn->donor_name ?? 'Bila Jina'),
                    $txn->category,
                    $txn->amount,
                    $txn->payment_method,
                    $txn->reference_number ?? '-',
                    $txn->approvedBy ? $txn->approvedBy->name : '-',
                    $txn->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Print-ready official church financial statement view.
     */
    public function printStatement(Request $request)
    {
        $church = Auth::user()->church;
        $user = Auth::user();
        $isMember = $user->isMember();
        $isTreasurer = $user->isTreasurer();

        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->format('Y-m-d'));

        $query = FinancialTransaction::with(['member', 'approvedBy'])
            ->where('status', 'confirmed')
            ->whereBetween('transaction_date', [$fromDate, $toDate]);

        if ($isMember) {
            $query->whereIn('category', ['building_offering', 'special_contribution', 'other_income']);
        } elseif ($isTreasurer) {
            $query->where('category', '!=', 'tithe');
        }

        $transactions = $query->orderBy('transaction_date', 'asc')->get();

        $expenses = Expense::where('status', 'approved')
            ->whereBetween('expense_date', [$fromDate, $toDate])
            ->orderBy('expense_date', 'asc')
            ->get();

        $totalIncome = $transactions->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        return view('finances.statement_print', compact(
            'church',
            'transactions',
            'expenses',
            'totalIncome',
            'totalExpense',
            'netBalance',
            'fromDate',
            'toDate',
            'isTreasurer',
            'isMember'
        ));
    }
}
