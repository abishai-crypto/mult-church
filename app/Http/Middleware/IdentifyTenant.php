<?php

namespace App\Http\Middleware;

use App\Models\Church;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentChurch = null;
        $allChurches = collect();

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->isSuperAdmin()) {
                $allChurches = Church::orderBy('name')->get();
                $activeId = session('active_church_id');
                if ($activeId) {
                    $currentChurch = Church::find($activeId);
                }
            } elseif ($user->church_id) {
                session(['active_church_id' => $user->church_id]);
                $currentChurch = Church::find($user->church_id);

                // If tenant is deactivated or expired
                if ($currentChurch && !$currentChurch->is_active && !$request->is('logout*')) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->route('login')->withErrors(['email' => 'This church tenant account is currently deactivated. Please contact support.']);
                }
            }
        }

        // Share globally with all Blade views
        View::share('currentChurch', $currentChurch);
        View::share('allChurches', $allChurches);

        return $next($request);
    }
}
