<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'title',
        'project_type',
        'estimated_cost',
        'raised_amount',
        'spent_amount',
        'start_date',
        'target_completion_date',
        'status', // planning, in_progress, on_hold, completed
        'location',
        'leader_name',
        'description',
        'photo_path',
        'created_by',
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'raised_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
        'start_date' => 'date',
        'target_completion_date' => 'date',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function progressPercent(): float
    {
        if ($this->estimated_cost <= 0) {
            return 0;
        }
        return min(100, round(($this->raised_amount / $this->estimated_cost) * 100, 1));
    }
}
