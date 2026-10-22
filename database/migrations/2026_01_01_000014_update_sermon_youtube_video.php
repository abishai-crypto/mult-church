<?php

use App\Models\Church;
use App\Models\YoutubeVideo;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Futa kabisa video yoyote ya kidunia au placeholder (kJQP7kiw5Fk)
        YoutubeVideo::where('youtube_id', 'kJQP7kiw5Fk')
            ->orWhere('video_url', 'like', '%kJQP7kiw5Fk%')
            ->orWhere('title', 'like', '%Despacito%')
            ->delete();

        // 2. Hakikisha video rasmi ya Mchungaji Lukas J. Kittu "Je, Umegeuzwa" ipo
        $church = Church::where('slug', 'eagt-golani')->first() ?? Church::first();
        $churchId = $church ? $church->id : 1;

        YoutubeVideo::updateOrCreate(
            ['youtube_id' => 'DGN4B4CFn3g'],
            [
                'church_id' => $churchId,
                'title' => 'Somo: Je, Umegeuzwa Kuwa Mtu Mwingine? | Mchungaji Lukas J. Kittu',
                'video_url' => 'https://www.youtube.com/watch?v=DGN4B4CFn3g',
                'is_live' => false,
                'preacher_name' => 'Mchungaji Lukas J. Kittu',
                'sermon_series' => 'Kugeuzwa na Roho Mtakatifu (1 Samweli 10:6)',
                'sermon_date' => now()->subDays(3)->format('Y-m-d'),
                'description' => 'Mahubiri ya Neno la Mungu kutoka kwa Mchungaji Kiongozi Lukas J. Kittu katika Hekalu Kuu la EAGT Golani, Kimara-Suka Dar es Salaam: "Naye Roho wa BWANA atakujilia kwa nguvu, nawe utatabiri pamoja nao, nawe UTAGEUZWA kuwa mtu mwingine." (1 Samweli 10:6). Sikiliza ujumbe huu upokee upako na mpenyo wa maisha yako.',
            ]
        );
    }

    public function down(): void
    {
        //
    }
};
