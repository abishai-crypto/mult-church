<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeVideo extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'title',
        'video_url',
        'youtube_id',
        'is_live',
        'preacher_name',
        'sermon_series',
        'sermon_date',
        'description',
        'thumbnail_url',
        'added_by',
    ];

    protected $casts = [
        'is_live' => 'boolean',
        'sermon_date' => 'date',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function getEmbedUrlAttribute(): string
    {
        return "https://www.youtube.com/embed/{$this->youtube_id}";
    }

    public function getAutoThumbnailAttribute(): string
    {
        if ($this->thumbnail_url) {
            return $this->thumbnail_url;
        }
        return "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
    }
}
