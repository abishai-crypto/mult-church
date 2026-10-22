<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $churches = Church::where('is_active', true)->orderBy('name')->get();
        return view('auth.login', compact('churches'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->church_id) {
                session(['active_church_id' => $user->church_id]);
            }

            AuditService::log('login', "Mtumiaji {$user->name} ameingia kwenye mfumo.");

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Barua pepe au nenosiri halilingani na kumbukumbu zetu.',
        ])->onlyInput('email');
    }

    public function demoLogin(string $role, Request $request)
    {
        $emailMap = [
            'super_admin' => 'superadmin@multichurch.org',
            'church_admin' => 'admin@eagt.org',
            'pastor' => 'pastor@eagt.org',
            'elder' => 'elder@eagt.org',
            'treasurer' => 'treasurer@eagt.org',
            'secretary' => 'secretary@eagt.org',
            'youth_leader' => 'youthleader@eagt.org',
            'member' => 'member@eagt.org',
        ];

        if (!isset($emailMap[$role])) {
            return redirect()->route('login');
        }

        $user = User::where('email', $emailMap[$role])->first();
        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            if ($user->church_id) {
                session(['active_church_id' => $user->church_id]);
            } else {
                session()->forget('active_church_id');
            }

            $swahiliRoles = [
                'super_admin' => 'Msimamizi Mkuu wa Mfumo',
                'church_admin' => 'Msimamizi wa Kanisa',
                'pastor' => 'Mchungaji Kiongozi',
                'elder' => 'Mzee wa Kanisa',
                'treasurer' => 'Mhazini / Mtunza Hazina',
                'secretary' => 'Katibu wa Kanisa',
                'youth_leader' => 'Kiongozi wa Idara (CPV)',
                'member' => 'Mshirika wa Kanisa',
            ];

            $roleName = $swahiliRoles[$role] ?? $role;

            AuditService::log('login', "Kuingia kwa jaribio kama {$user->name} ({$roleName})");
            return redirect()->route('dashboard')->with('success', "Karibu sana! Umeingia kama {$roleName} ({$user->name})");
        }

        return redirect()->route('login')->withErrors(['email' => 'Akaunti ya majaribio haikupatikana.']);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            AuditService::log('logout', "Mtumiaji " . Auth::user()->name . " ametoka kwenye mfumo.");
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Umetoka kwenye mfumo kwa usalama.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        if (!empty($validated['current_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Nenosiri la sasa halilingani.']);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->save();

        AuditService::log('updated', "Kuhuisha wasifu wa mtumiaji", 'User', $user->id);

        return back()->with('success', 'Wasifu wako umehuishwa kikamilifu.');
    }
}
