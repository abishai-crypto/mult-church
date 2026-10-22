<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'service_id',
        'department_id',
        'attendance_date',
        'men_count',
        'women_count',
        'children_count',
        'total_count',
        'first_timers_count',
        'new_converts_count',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'men_count' => 'integer',
        'women_count' => 'integer',
        'children_count' => 'integer',
        'total_count' => 'integer',
        'first_timers_count' => 'integer',
        'new_converts_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function ($attendance) {
            $attendance->total_count = ($attendance->men_count ?? 0) + ($attendance->women_count ?? 0) + ($attendance->children_count ?? 0);
        });
    }

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
