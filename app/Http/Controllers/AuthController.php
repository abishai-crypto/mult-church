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

    public function showForgotPassword()
    {
        return view('auth.forgot_password');
    }

    public function sendResetRequest(Request $request)
    {
        $validated = $request->validate([
            'identifier' => 'required|string',
            'requester_name' => 'nullable|string|max:150',
            'reason' => 'nullable|string|max:500',
        ], [
            'identifier.required' => 'Tafadhali weka barua pepe au namba yako ya simu iliyosajiliwa kanisani.',
        ]);

        $identifier = trim($validated['identifier']);
        $cleanedPhone = \App\Services\SmsService::formatTanzanianPhone($identifier);

        $user = User::where('email', $identifier)
            ->orWhere('phone', $identifier)
            ->orWhere('phone', $cleanedPhone)
            ->first();

        $church = Church::where('slug', 'eagt-golani')->first() ?? Church::first();
        $churchId = $user ? $user->church_id : ($church ? $church->id : 1);
        $userEmail = $user ? $user->email : (filter_var($identifier, FILTER_VALIDATE_EMAIL) ? $identifier : 'haijulikani@eagt.org');
        $userPhone = $user ? $user->phone : (!filter_var($identifier, FILTER_VALIDATE_EMAIL) ? $identifier : null);
        $userName = !empty($validated['requester_name']) ? $validated['requester_name'] : ($user ? $user->name : 'Muumini wa Kanisa');

        $resetReq = \App\Models\PasswordResetRequest::create([
            'church_id' => $churchId,
            'user_id' => $user?->id,
            'email' => $userEmail,
            'phone' => $userPhone,
            'requester_name' => $userName,
            'reason' => $validated['reason'] ?? 'Nimesahau nenosiri la kuingilia mfumo.',
            'status' => 'pending',
        ]);

        AuditService::notifyRole(
            $churchId,
            ['pastor', 'elder', 'church_admin'],
            'Ombi la Kurejesha Nenosiri la Kikanisa',
            "Mtumiaji {$userName} ({$identifier}) ameomba kurejeshewa nenosiri. Tafadhali kagua na uidhinishe kikanisa.",
            'warning',
            route('security.passwords.index')
        );

        AuditService::log(
            'security',
            "Ombi la kurejesha nenosiri limewasilishwa kwa {$identifier} ({$userName})",
            'PasswordResetRequest',
            $resetReq->id
        );

        return back()->with('success', 'Bwana Asifiwe! Ombi lako la kurejesha nenosiri limewasilishwa rasmi kwa Ofisi ya Mchungaji Kiongozi na Wazee wa Kanisa. Watahakiki utambulisho wako na utapokea nenosiri jipya la muda kwa ujumbe wa simu (SMS) au barua pepe.');
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
