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

        // Muktadha wa Kanisa Husika (EAGT Golani)
        $churchId = session('active_church_id') ?? $user->church_id;
        $church = Church::find($churchId);

        $totalMembers = Member::count();
        $activeMembers = Member::where('membership_status', 'Active')->count();
        $departmentsCount = Department::where('is_active', true)->count();

        // Mahudhurio
        $latestAttendance = Attendance::orderBy('attendance_date', 'desc')->first();
        $recentAttendances = Attendance::with('service')
            ->orderBy('attendance_date', 'asc')
            ->take(6)
            ->get();

        $attendanceChartData = [
            'labels' => $recentAttendances->map(fn($a) => $a->attendance_date->format('d M'))->toArray(),
            'total' => $recentAttendances->pluck('total_count')->toArray(),
            'men' => $recentAttendances->pluck('men_count')->toArray(),
            'women' => $recentAttendances->pluck('women_count')->toArray(),
            'children' => $recentAttendances->pluck('children_count')->toArray(),
        ];

        // SHERIA YA KANISA: 
        // 1. Mshirika asione Sadaka za kawaida, Zaka na Shukrani (anaona michango ya ujenzi, miradi na matumizi pekee).
        // 2. Mhazini haoni Zaka zilizothibitishwa (zinaenda kwa Mchungaji).
        // 3. Wazee wa Kanisa na Mchungaji pekee wanaona Zaka na Sadaka zote.
        $isMember = $user->isMember();
        $isTreasurer = $user->isTreasurer();

        if ($isMember) {
            // Mshirika anaona michango ya ujenzi na makusanyo mengine ya miradi pekee
            $totalConfirmedIncome = FinancialTransaction::where('status', 'confirmed')
                ->whereIn('category', ['building_offering', 'special_contribution', 'other_income'])
                ->sum('amount');
            $totalTithes = null;
            $totalPendingOfferings = 0;
            $pendingCount = 0;
        } elseif ($isTreasurer) {
            $totalConfirmedIncome = FinancialTransaction::where('status', 'confirmed')
                ->where('category', '!=', 'tithe')
                ->sum('amount');
            $totalTithes = null;
            $totalPendingOfferings = FinancialTransaction::where('status', 'pending')->sum('amount');
            $pendingCount = FinancialTransaction::where('status', 'pending')->count();
        } else {
            $totalConfirmedIncome = FinancialTransaction::where('status', 'confirmed')->sum('amount');
            $totalTithes = FinancialTransaction::where('status', 'confirmed')->where('category', 'tithe')->sum('amount');
            $totalPendingOfferings = FinancialTransaction::where('status', 'pending')->sum('amount');
            $pendingCount = FinancialTransaction::where('status', 'pending')->count();
        }

        $totalExpenses = Expense::where('status', 'approved')->sum('amount');
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
            $financeCategoriesData[$catLabel] = (float) $sum;
        }

        // Matangazo na Matukio
        $pinnedAnnouncements = Announcement::where('is_pinned', true)->latest()->take(3)->get();
        $upcomingEvents = Event::where('start_time', '>=', now())->orderBy('start_time')->take(3)->get();

        // Miradi inayoendelea
        $activeProjects = Project::where('status', 'in_progress')->take(3)->get();

        // Maombi yanayosubiri
        $pendingPrayersCount = PrayerRequest::where('status', 'pending')->count();

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
