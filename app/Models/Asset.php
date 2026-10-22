<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'project_id',
        'name',
        'asset_code',
        'category',
        'purchase_date',
        'purchase_price',
        'current_value',
        'condition', // new, good, fair, needs_repair, disposed
        'location',
        'serial_number',
        'warranty_info',
        'maintenance_notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
        'current_value' => 'decimal:2',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
