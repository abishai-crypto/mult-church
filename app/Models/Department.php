<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'name',
        'slug',
        'description',
        'leader_name',
        'leader_phone',
        'meeting_day',
        'meeting_time',
        'banner_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function departmentMembers()
    {
        return $this->hasMany(DepartmentMember::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'department_members')
                    ->withPivot('role_in_department', 'joined_at', 'is_active')
                    ->withTimestamps();
    }

    public function finances()
    {
        return $this->hasMany(DepartmentFinance::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function totalIncome()
    {
        return $this->finances()->where('type', 'income')->sum('amount');
    }

    public function totalExpense()
    {
        return $this->finances()->where('type', 'expense')->sum('amount');
    }

    public function balance()
    {
        return $this->totalIncome() - $this->totalExpense();
    }
}