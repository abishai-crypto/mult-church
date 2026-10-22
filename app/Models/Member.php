<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'member_number',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'marital_status',
        'phone',
        'email',
        'residential_address',
        'occupation',
        'baptism_status',
        'baptism_date',
        'membership_status',
        'joined_date',
        'emergency_contact_name',
        'emergency_contact_phone',
        'photo_path',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'baptism_date' => 'date',
        'joined_date' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'member_id');
    }

    public function departmentMembers()
    {
        return $this->hasMany(DepartmentMember::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_members')
                    ->withPivot('role_in_department', 'joined_at', 'is_active')
                    ->withTimestamps();
    }

    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function pastoralVisits()
    {
        return $this->hasMany(PastoralVisit::class);
    }

    public function prayerRequests()
    {
        return $this->hasMany(PrayerRequest::class);
    }
}
