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
            } else {
                $churchId = session('active_church_id') ?? $user->church_id;
                $currentChurch = $churchId ? Church::find($churchId) : null;
                if (!$currentChurch) {
                    $currentChurch = Church::where('slug', 'eagt-golani')->first() ?? Church::first();
                }

                if ($currentChurch) {
                    session(['active_church_id' => $currentChurch->id]);

                    // If tenant is deactivated or expired
                    if (!$currentChurch->is_active && !$request->is('logout*')) {
                        Auth::logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                        return redirect()->route('login')->withErrors(['login' => 'Akaunti ya hili tawi la kanisa imesimamishwa. Tafadhali wasiliana na uongozi.']);
                    }
                }
            }
        }

        // Share globally with all Blade views
        View::share('currentChurch', $currentChurch);
        View::share('allChurches', $allChurches);

        return $next($request);
    }
}
