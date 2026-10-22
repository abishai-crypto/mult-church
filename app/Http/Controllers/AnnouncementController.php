<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Department;
use App\Models\Event;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $pinnedAnnouncements = Announcement::with('author')
            ->where('is_pinned', true)
            ->latest()
            ->get();

        $regularAnnouncements = Announcement::with('author')
            ->where('is_pinned', false)
            ->latest()
            ->paginate(10);

        $upcomingEvents = Event::with('department')
            ->where('start_time', '>=', now()->subDay())
            ->orderBy('start_time', 'asc')
            ->get();

        $departments = Department::where('is_active', true)->get();

        return view('announcements.index', compact('pinnedAnnouncements', 'regularAnnouncements', 'upcomingEvents', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:normal,high,urgent',
            'audience' => 'required|in:all,members,leaders,department',
            'department_id' => 'nullable|exists:departments,id',
            'publish_date' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'is_pinned' => 'nullable|boolean',
        ]);

        $announcement = Announcement::create(array_merge($validated, [
            'is_pinned' => $request->has('is_pinned'),
            'posted_by' => Auth::id(),
        ]));

        AuditService::log('created', "Posted announcement: {$announcement->title}", 'Announcement', $announcement->id);

        return back()->with('success', "Announcement '{$announcement->title}' published.");
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'color' => 'required|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'is_public' => 'nullable|boolean',
        ]);

        $event = Event::create(array_merge($validated, [
            'is_public' => $request->has('is_public'),
            'created_by' => Auth::id(),
        ]));

        AuditService::log('created', "Scheduled event: {$event->title}", 'Event', $event->id);

        return back()->with('success', "Event '{$event->title}' scheduled on calendar.");
    }
}
