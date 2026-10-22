<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentFinance extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'department_id',
        'type', // income, expense
        'category',
        'amount',
        'currency',
        'transaction_date',
        'payment_method',
        'reference_number',
        'member_name',
        'description',
        'receipt_path',
        'recorded_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
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
