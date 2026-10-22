<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastoralVisit extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'member_id',
        'pastor_id',
        'visit_date',
        'visit_type',
        'notes',
        'follow_up_required',
        'follow_up_date',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'follow_up_date' => 'date',
        'follow_up_required' => 'boolean',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function pastor()
    {
        return $this->belongsTo(User::class, 'pastor_id');
    }
}
