<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurchNotification extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'user_id',
        'title',
        'message',
        'type', // info, success, warning, danger
        'link',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
