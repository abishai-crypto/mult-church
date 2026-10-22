<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'name',
        'email',
        'password',
        'phone',
        'role',
        'department_id',
        'member_id',
        'status',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Role helper methods
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isChurchAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'church_admin']);
    }

    public function isPastor(): bool
    {
        return in_array($this->role, ['super_admin', 'church_admin', 'pastor']);
    }

    public function isElder(): bool
    {
        return in_array($this->role, ['super_admin', 'church_admin', 'pastor', 'elder']);
    }

    public function isTreasurer(): bool
    {
        return in_array($this->role, ['super_admin', 'church_admin', 'treasurer']);
    }

    public function isSecretary(): bool
    {
        return in_array($this->role, ['super_admin', 'church_admin', 'secretary']);
    }

    public function isDepartmentLeader(): bool
    {
        return $this->role === 'department_leader';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    public function canViewTithesAndOfferings(): bool
    {
        return in_array($this->role, ['super_admin', 'church_admin', 'pastor', 'elder']);
    }

    public function canManagePasswords(): bool
    {
        // Mchungaji Kiongozi, Wazee wa Kanisa, na Wasimamizi ndio wenye mamlaka ya kikanisa
        return in_array($this->role, ['super_admin', 'church_admin', 'pastor', 'elder']);
    }

    public function canResetPasswordFor(User $targetUser): bool
    {
        // Super Admin ana mamlaka kamili
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Mchungaji Kiongozi ana mamlaka ya kikanisa kwa viongozi wote na washirika
        if ($this->isPastor()) {
            return !$targetUser->isSuperAdmin();
        }

        // Msimamizi wa Kanisa anaweza kubadili kwa watumishi na washirika (isipokuwa Mchungaji Kiongozi)
        if ($this->isChurchAdmin()) {
            return !in_array($targetUser->role, ['super_admin', 'pastor']);
        }

        // Mzee wa Kanisa ana mamlaka kikanisa juu ya viongozi wa idara na washirika
        if ($this->isElder()) {
            return in_array($targetUser->role, ['department_leader', 'member']);
        }

        return false;
    }

    // Relationships
    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function enteredTransactions()
    {
        return $this->hasMany(FinancialTransaction::class, 'entered_by');
    }

    public function approvedTransactions()
    {
        return $this->hasMany(FinancialTransaction::class, 'approved_by');
    }

    public function notifications()
    {
        return $this->hasMany(ChurchNotification::class)->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->hasMany(ChurchNotification::class)->where('is_read', false)->orderBy('created_at', 'desc');
    }
}