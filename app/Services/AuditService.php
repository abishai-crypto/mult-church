<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\ChurchNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditService
{
    /**
     * Record an audit log entry.
     */
    public static function log(
        string $action,
        string $description,
        ?string $entityType = null,
        ?int $entityId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?int $churchId = null
    ): AuditLog {
        $user = Auth::user();

        if (!$churchId) {
            $churchId = session('active_church_id') ?? ($user?->church_id ?? null);
        }

        return AuditLog::create([
            'church_id' => $churchId,
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'System',
            'action' => $action,
            'entity_type' => $entityType ?? 'General',
            'entity_id' => $entityId,
            'description' => $description,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'created_at' => now(),
        ]);
    }

    /**
     * Send in-app notification to church users or specific role.
     */
    public static function notifyRole(
        int $churchId,
        array|string $roles,
        string $title,
        string $message,
        string $type = 'info',
        ?string $link = null
    ): void {
        $rolesArray = is_array($roles) ? $roles : [$roles];

        $users = User::where('church_id', $churchId)
            ->whereIn('role', $rolesArray)
            ->where('status', 'active')
            ->get();

        foreach ($users as $user) {
            ChurchNotification::create([
                'church_id' => $churchId,
                'user_id' => $user->id,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'link' => $link,
                'is_read' => false,
            ]);
        }
    }
}
