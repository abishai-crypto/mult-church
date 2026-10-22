<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'tagline',
        'email',
        'phone',
        'address',
        'currency',
        'currency_symbol',
        'timezone',
        'logo_path',
        'primary_color',
        'secondary_color',
        'modules',
        'subscription_status',
        'subscription_expires_at',
        'is_active',
    ];

    protected $casts = [
        'modules' => 'array',
        'is_active' => 'boolean',
        'subscription_expires_at' => 'datetime',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function youtubeVideos()
    {
        return $this->hasMany(YoutubeVideo::class);
    }

    public function prayerRequests()
    {
        return $this->hasMany(PrayerRequest::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Check if a specific module is enabled for this church.
     */
    public function hasModule(string $moduleKey): bool
    {
        if (empty($this->modules)) {
            return true; // All default enabled if null
        }
        return in_array($moduleKey, $this->modules, true);
    }
}
