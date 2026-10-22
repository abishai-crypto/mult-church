<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'department_id',
        'title',
        'content',
        'priority', // normal, high, urgent
        'audience', // all, members, leaders, department
        'publish_date',
        'expires_at',
        'is_pinned',
        'posted_by',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'expires_at' => 'date',
        'is_pinned' => 'boolean',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }
}
