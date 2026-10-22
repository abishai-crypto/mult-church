<?php

namespace App\Traits;

use App\Models\Church;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait BelongsToChurch
{
    /**
     * Boot the BelongsToChurch trait for a model.
     */
    protected static function bootBelongsToChurch(): void
    {
        static::addGlobalScope('church', function (Builder $builder) {
            $churchId = static::resolveCurrentChurchId();
            if ($churchId) {
                $builder->where($builder->getModel()->getTable() . '.church_id', $churchId);
            }
        });

        static::creating(function (Model $model) {
            if (empty($model->church_id)) {
                $churchId = static::resolveCurrentChurchId();
                if ($churchId) {
                    $model->church_id = $churchId;
                }
            }
        });
    }

    /**
     * Resolve the current church ID from authenticated user, session, or active context.
     */
    public static function resolveCurrentChurchId(): ?int
    {
        if (app()->runningInConsole() && !session()->has('active_church_id')) {
            return null;
        }

        // If Super Admin has selected an active church context in session
        if (session()->has('active_church_id')) {
            return (int) session('active_church_id');
        }

        // If user is authenticated, use user's church_id
        if (Auth::check() && Auth::user()->church_id) {
            return (int) Auth::user()->church_id;
        }

        return null;
    }

    /**
     * Relationship to the Church tenant.
     */
    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id');
    }
}
