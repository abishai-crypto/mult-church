<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\AuditLog;
use App\Models\Church;
use App\Models\Department;
use App\Models\Event;
use App\Models\Expense;
use App\Models\FinancialTransaction;
use App\Models\Member;
use App\Models\PrayerRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $isSuperAdminGlobal = $user->isSuperAdmin() && !session()->has('active_church_id');

        if ($isSuperAdminGlobal) {
            $totalChurches = Church::count();
            $activeChurches = Church::where('is_active', true)->count();
            $totalUsers = User::count();
            $totalMembers = Member::withoutGlobalScope('church')->count();
            $churches = Church::withCount(['users', 'members'])->orderBy('created_at', 'desc')->get();
            $recentAuditLogs = AuditLog::withoutGlobalScope('church')->orderBy('created_at', 'desc')->take(8)->get();

            return view('dashboard.superadmin', compact(
                'totalChurches',
                'activeChurches',
                'totalUsers',
                'totalMembers',
                'churches',
                'recentAuditLogs'
            ));
        }

        // Muktadha wa Kanisa Husika (EAGT Golani) na Fallback Imara
        $churchId = session('active_church_id') ?? $user->church_id;
        $church = null;
        if ($churchId) {
            $church = Church::find($churchId);
        }
        if (!$church) {
            $church = Church::where('slug', 'eagt-golani')->first() ?? Church::first();
        }
        if (!$church) {
            $church = Church::firstOrCreate(
                ['slug' => 'eagt-golani'],
                [
                    'name' => 'EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT)',
                    'code' => 'EAGT-GLN',
                    'tagline' => 'Golani, Kimara-Suka - Dar es Salaam | Neno la Msalaba ni Nguvu ya Mungu',
                    'email' => 'golani@eagt.org',
                    'phone' => '+255 754 123 456',
                    'address' => 'Mtaa wa Golani, Kimara-Suka, Manispaa ya Ubungo, Dar es Salaam, Tanzania',
                    'currency' => 'TZS',
                    'currency_symbol' => 'Tsh',
                    'timezone' => 'Africa/Dar_es_Salaam',
                    'primary_color' => '#1e3a8a',
                    'secondary_color' => '#d97706',
                    'modules' => ['members', 'finances', 'attendance', 'departments', 'pastoral_care', 'documents', 'media', 'projects', 'assets', 'events'],
                    'subscription_status' => 'active',
                    'subscription_expires_at' => now()->addYears(5),
                    'is_active' => true,
                ]
            );
        }

        // Unganisha mtumiaji kwenye kanisa hili na weka session
        if ($church && !$user->church_id && !$user->isSuperAdmin() && $user->exists) {
            $user->church_id = $church->id;
            $user->saveQuietly();
        }
        if ($church) {
            session(['active_church_id' => $church->id]);
        }

        $totalMembers = (int) Member::count();
        $activeMembers = (int) Member::where('membership_status', 'Active')->count();
        $departmentsCount = (int) Department::where('is_active', true)->count();

        // Mahudhurio
        $latestAttendance = Attendance::orderBy('attendance_date', 'desc')->first();
        $recentAttendances = Attendance::with('service')
            ->orderBy('attendance_date', 'asc')
            ->take(6)
            ->get();

        $attendanceChartData = [
            'labels' => $recentAttendances->map(function ($a) {
                if ($a->attendance_date) {
                    return is_string($a->attendance_date) ? date('d M', strtotime($a->attendance_date)) : $a->attendance_date->format('d M');
                }
                return '';
            })->toArray(),
            'total' => $recentAttendances->map(fn($a) => (int) ($a->total_count ?? 0))->toArray(),
            'men' => $recentAttendances->map(fn($a) => (int) ($a->men_count ?? 0))->toArray(),
            'women' => $recentAttendances->map(fn($a) => (int) ($a->women_count ?? 0))->toArray(),
            'children' => $recentAttendances->map(fn($a) => (int) ($a->children_count ?? 0))->toArray(),
        ];

        // SHERIA YA KANISA: 
        // 1. Mshirika asione Sadaka za kawaida, Zaka na Shukrani (anaona michango ya ujenzi, miradi na matumizi pekee).
        // 2. Mhazini haoni Zaka zilizothibitishwa (zinaenda kwa Mchungaji).
        // 3. Wazee wa Kanisa na Mchungaji pekee wanaona Zaka na Sadaka zote.
        $isMember = $user->isMember();
        $isTreasurer = $user->isTreasurer();

        if ($isMember) {
            // Mshirika anaona michango ya ujenzi na makusanyo mengine ya miradi pekee
            $totalConfirmedIncome = (float) (FinancialTransaction::where('status', 'confirmed')
                ->whereIn('category', ['building_offering', 'special_contribution', 'other_income'])
                ->sum('amount') ?? 0);
            $totalTithes = 0.0;
            $totalPendingOfferings = 0.0;
            $pendingCount = 0;
        } elseif ($isTreasurer) {
            $totalConfirmedIncome = (float) (FinancialTransaction::where('status', 'confirmed')
                ->where('category', '!=', 'tithe')
                ->sum('amount') ?? 0);
            $totalTithes = 0.0;
            $totalPendingOfferings = (float) (FinancialTransaction::where('status', 'pending')->sum('amount') ?? 0);
            $pendingCount = (int) FinancialTransaction::where('status', 'pending')->count();
        } else {
            $totalConfirmedIncome = (float) (FinancialTransaction::where('status', 'confirmed')->sum('amount') ?? 0);
            $totalTithes = (float) (FinancialTransaction::where('status', 'confirmed')->where('category', 'tithe')->sum('amount') ?? 0);
            $totalPendingOfferings = (float) (FinancialTransaction::where('status', 'pending')->sum('amount') ?? 0);
            $pendingCount = (int) FinancialTransaction::where('status', 'pending')->count();
        }

        $totalExpenses = (float) (Expense::where('status', 'approved')->sum('amount') ?? 0);
        $netBalance = $totalConfirmedIncome - $totalExpenses;

        // Mgawanyo wa Mapato kwa Chati
        if ($isMember) {
            $categoriesMap = [
                'building_offering' => 'Mchango wa Ujenzi',
                'special_contribution' => 'Michango Maalum ya Miradi',
                'other_income' => 'Makusanyo Mengine',
            ];
        } else {
            $categoriesMap = [
                'regular_offering' => 'Sadaka ya Jumapili',
                'thanksgiving' => 'Sadaka ya Shukrani',
                'building_offering' => 'Mchango wa Ujenzi',
                'special_contribution' => 'Michango Maalum',
            ];

            // Mchungaji, Mzee au Admin pekee ndiye anayeona Zaka kwenye grafu
            if (!$isTreasurer) {
                $categoriesMap['tithe'] = 'Zaka (Fungu la Kumi)';
            }
        }

        $financeCategoriesData = [];
        foreach ($categoriesMap as $catKey => $catLabel) {
            $sum = FinancialTransaction::where('status', 'confirmed')
                ->where('category', $catKey)
                ->sum('amount');
            $financeCategoriesData[$catLabel] = (float) ($sum ?? 0);
        }

        // Matangazo na Matukio
        $pinnedAnnouncements = Announcement::where('is_pinned', true)->latest()->take(3)->get();
        $upcomingEvents = Event::where('start_time', '>=', now())->orderBy('start_time')->take(3)->get();

        // Miradi inayoendelea
        $activeProjects = Project::where('status', 'in_progress')->take(3)->get();

        // Maombi yanayosubiri
        $pendingPrayersCount = (int) PrayerRequest::where('status', 'pending')->count();

        // Miamala ya hivi karibuni
        $recentTransactionsQuery = FinancialTransaction::with(['member', 'enteredBy'])
            ->latest('transaction_date');

        if ($isMember) {
            // Mshirika anaona tu michango ya ujenzi na makusanyo ya miradi yaliyothibitishwa
            $recentTransactionsQuery->where('status', 'confirmed')
                ->whereIn('category', ['building_offering', 'special_contribution', 'other_income']);
        } elseif ($isTreasurer) {
            $recentTransactionsQuery->where(function ($q) {
                $q->where('category', '!=', 'tithe')
                  ->orWhere('status', 'pending');
            });
        }

        $recentTransactions = $recentTransactionsQuery->take(5)->get();

        return view('dashboard.church', compact(
            'church',
            'totalMembers',
            'activeMembers',
            'departmentsCount',
            'latestAttendance',
            'attendanceChartData',
            'totalConfirmedIncome',
            'totalTithes',
            'totalPendingOfferings',
            'pendingCount',
            'totalExpenses',
            'netBalance',
            'financeCategoriesData',
            'pinnedAnnouncements',
            'upcomingEvents',
            'activeProjects',
            'pendingPrayersCount',
            'recentTransactions',
            'isTreasurer',
            'isMember'
        ));
    }
}
