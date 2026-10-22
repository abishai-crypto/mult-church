<?php

namespace App\Http\Controllers;

use App\Models\YoutubeVideo;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function index()
    {
        $videos = YoutubeVideo::with('addedBy')->orderBy('sermon_date', 'desc')->paginate(9);
        $liveVideo = YoutubeVideo::where('is_live', true)->first();

        return view('media.index', compact('videos', 'liveVideo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'preacher_name' => 'nullable|string|max:100',
            'sermon_series' => 'nullable|string|max:100',
            'sermon_date' => 'nullable|date',
            'description' => 'nullable|string',
            'is_live' => 'nullable|boolean',
        ]);

        // Extract YouTube Video ID
        $youtubeId = $this->extractYoutubeId($validated['video_url']);
        if (!$youtubeId) {
            return back()->withErrors(['video_url' => 'Could not extract a valid YouTube video ID from the provided URL.'])->withInput();
        }

        $isLive = $request->has('is_live');
        if ($isLive) {
            // Unmark any previous live video
            YoutubeVideo::where('is_live', true)->update(['is_live' => false]);
        }

        $video = YoutubeVideo::create(array_merge($validated, [
            'youtube_id' => $youtubeId,
            'is_live' => $isLive,
            'added_by' => Auth::id(),
        ]));

        AuditService::log('created', "Added YouTube Sermon: {$video->title}", 'YoutubeVideo', $video->id);

        return back()->with('success', "YouTube video '{$video->title}' added successfully.");
    }

    public function toggleLive(YoutubeVideo $video)
    {
        if (!$video->is_live) {
            YoutubeVideo::where('is_live', true)->update(['is_live' => false]);
            $video->update(['is_live' => true]);
            $msg = "Set '{$video->title}' as the ACTIVE live stream.";
        } else {
            $video->update(['is_live' => false]);
            $msg = "Removed live stream flag.";
        }

        AuditService::log('updated', $msg, 'YoutubeVideo', $video->id);

        return back()->with('success', $msg);
    }

    private function extractYoutubeId(string $url): ?string
    {
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
