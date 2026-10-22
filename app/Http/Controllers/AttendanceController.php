<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Service;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['service', 'recorder'])
            ->orderBy('attendance_date', 'desc')
            ->paginate(15);

        $services = Service::where('is_active', true)->get();

        $latestAttendance = Attendance::latest('attendance_date')->first();
        $avgAttendance = (int) Attendance::avg('total_count');
        $totalFirstTimers = Attendance::sum('first_timers_count');
        $totalConverts = Attendance::sum('new_converts_count');

        // Past 8 services for charts
        $chartAttendances = Attendance::with('service')
            ->orderBy('attendance_date', 'asc')
            ->take(8)
            ->get();

        $chartData = [
            'labels' => $chartAttendances->map(fn($a) => $a->attendance_date->format('M d'))->toArray(),
            'total' => $chartAttendances->pluck('total_count')->toArray(),
            'men' => $chartAttendances->pluck('men_count')->toArray(),
            'women' => $chartAttendances->pluck('women_count')->toArray(),
            'children' => $chartAttendances->pluck('children_count')->toArray(),
        ];

        return view('attendance.index', compact(
            'attendances',
            'services',
            'latestAttendance',
            'avgAttendance',
            'totalFirstTimers',
            'totalConverts',
            'chartData'
        ));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        return view('attendance.create', compact('services', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'department_id' => 'nullable|exists:departments,id',
            'attendance_date' => 'required|date',
            'men_count' => 'required|integer|min:0',
            'women_count' => 'required|integer|min:0',
            'children_count' => 'required|integer|min:0',
            'first_timers_count' => 'nullable|integer|min:0',
            'new_converts_count' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $total = $validated['men_count'] + $validated['women_count'] + $validated['children_count'];

        $attendance = Attendance::create(array_merge($validated, [
            'total_count' => $total,
            'first_timers_count' => $validated['first_timers_count'] ?? 0,
            'new_converts_count' => $validated['new_converts_count'] ?? 0,
            'recorded_by' => Auth::id(),
        ]));

        $serviceName = Service::find($validated['service_id'])?->title;
        AuditService::log('created', "Logged attendance for {$serviceName} on {$attendance->attendance_date->format('Y-m-d')} (Total: {$total})", 'Attendance', $attendance->id);

        return redirect()->route('attendance.index')->with('success', "Attendance record saved successfully! Total headcount: {$total}");
    }

    public function services()
    {
        $services = Service::withCount('attendances')->get();
        return view('attendance.services', compact('services'));
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'service_type' => 'required|string|max:50',
            'day_of_week' => 'nullable|string|max:20',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $service = Service::create(array_merge($validated, ['is_active' => true]));

        AuditService::log('created', "Created service program {$service->title}", 'Service', $service->id);

        return back()->with('success', "Service '{$service->title}' created.");
    }

    /**
     * Export attendance data as CSV.
     */
    public function exportCsv()
    {
        $attendances = Attendance::with('service')->orderBy('attendance_date', 'desc')->get();
        $filename = 'takwimu_za_mahudhurio_' . date('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($attendances) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Tarehe',
                'Ibada / Programu',
                'Wanaume',
                'Wanawake',
                'Watoto',
                'Jumla Kuu',
                'Wageni (First Timers)',
                'Waliookoka Upya',
                'Maelezo',
            ]);

            foreach ($attendances as $a) {
                fputcsv($file, [
                    $a->attendance_date->format('Y-m-d'),
                    $a->service ? $a->service->title : 'Ibada',
                    $a->men_count,
                    $a->women_count,
                    $a->children_count,
                    $a->total_count,
                    $a->first_timers_count,
                    $a->new_converts_count,
                    $a->notes ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Print summary report for attendance.
     */
    public function printSummary()
    {
        $church = Auth::user()->church;
        $attendances = Attendance::with(['service', 'recorder'])->orderBy('attendance_date', 'desc')->take(20)->get();

        $totalMen = $attendances->sum('men_count');
        $totalWomen = $attendances->sum('women_count');
        $totalChildren = $attendances->sum('children_count');
        $totalOverall = $attendances->sum('total_count');
        $totalFirstTimers = $attendances->sum('first_timers_count');
        $totalConverts = $attendances->sum('new_converts_count');

        return view('attendance.summary_print', compact(
            'church',
            'attendances',
            'totalMen',
            'totalWomen',
            'totalChildren',
            'totalOverall',
            'totalFirstTimers',
            'totalConverts'
        ));
    }
}
