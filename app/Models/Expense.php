<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'expense_code',
        'title',
        'category',
        'amount',
        'currency',
        'expense_date',
        'payment_method',
        'recipient_name',
        'description',
        'receipt_path',
        'status', // pending, approved, paid, rejected
        'entered_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
        'approved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($expense) {
            if (empty($expense->expense_code)) {
                $expense->expense_code = 'EXP-' . strtoupper(uniqid());
            }
        });
    }

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function enteredBy()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
