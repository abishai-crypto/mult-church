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
        // 1. Futa kabisa rekodi ya placeholder video
        YoutubeVideo::withoutGlobalScope('church')
            ->where('youtube_id', 'kJQP7kiw5Fk')
            ->orWhere('video_url', 'like', '%kJQP7kiw5Fk%')
            ->delete();

        // 2. Hakikisha somo rasmi la Mchungaji Lukas J. Kittu lipo daima
        $hasSermon = YoutubeVideo::withoutGlobalScope('church')->where('youtube_id', 'DGN4B4CFn3g')->exists();
        if (!$hasSermon) {
            $church = \App\Models\Church::where('slug', 'eagt-golani')->first() ?? \App\Models\Church::first();
            YoutubeVideo::create([
                'church_id' => $church ? $church->id : 1,
                'title' => 'Somo: Je, Umegeuzwa Kuwa Mtu Mwingine? | Mchungaji Lukas J. Kittu',
                'video_url' => 'https://www.youtube.com/watch?v=DGN4B4CFn3g',
                'youtube_id' => 'DGN4B4CFn3g',
                'is_live' => false,
                'preacher_name' => 'Mchungaji Lukas J. Kittu',
                'sermon_series' => 'Kugeuzwa na Roho Mtakatifu (1 Samweli 10:6)',
                'sermon_date' => now()->subDays(3)->format('Y-m-d'),
                'description' => 'Mahubiri ya Neno la Mungu kutoka kwa Mchungaji Kiongozi Lukas J. Kittu katika Hekalu Kuu la EAGT Golani, Kimara-Suka Dar es Salaam: "Naye Roho wa BWANA atakujilia kwa nguvu, nawe utatabiri pamoja nao, nawe UTAGEUZWA kuwa mtu mwingine." (1 Samweli 10:6). Sikiliza ujumbe huu upokee upako na mpenyo wa maisha yako.',
                'added_by' => Auth::id(),
            ]);
        }

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
