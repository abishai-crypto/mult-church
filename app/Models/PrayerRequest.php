<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'member_id',
        'requester_name',
        'requester_phone',
        'category',
        'request_text',
        'is_confidential',
        'status', // pending, praying, answered
        'pastoral_notes',
        'testimony',
    ];

    protected $casts = [
        'is_confidential' => 'boolean',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
