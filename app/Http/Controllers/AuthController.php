<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\Department;
use App\Models\DepartmentMember;
use App\Models\Member;
use App\Models\User;
use App\Services\AuditService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $loginInput = trim((string) ($request->input('login') ?: $request->input('email', '')));
        $password = (string) $request->input('password', '');

        if (empty($loginInput) || empty($password)) {
            return back()->withErrors([
                'login' => 'Tafadhali weka barua pepe au nambari ya simu pamoja na nenosiri lako.',
            ])->onlyInput('login');
        }

        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);

        $user = null;
        if ($isEmail) {
            $user = User::where('email', $loginInput)->first();
        } else {
            // Find user by phone in various representations
            $formattedPhone = SmsService::formatTanzanianPhone($loginInput);
            $localPhone = preg_replace('/^\+255/', '0', $formattedPhone);
            $digits = preg_replace('/[^0-9]/', '', $loginInput);
            $last9 = strlen($digits) >= 9 ? substr($digits, -9) : null;

            $user = User::where('phone', $loginInput)
                ->orWhere('phone', $formattedPhone)
                ->orWhere('phone', '+' . $formattedPhone)
                ->orWhere('phone', $localPhone)
                ->when($last9, function ($query) use ($last9) {
                    $query->orWhereRaw("RIGHT(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '+', ''), '-', ''), 9) = ?", [$last9]);
                })
                ->orWhere('email', $loginInput)
                ->first();
        }

        if ($user && Hash::check($password, $user->password)) {
            if ($user->status === 'inactive' || $user->status === 'suspended') {
                return back()->withErrors([
                    'login' => 'Akaunti hii imesimamishwa. Tafadhali wasiliana na ofisi ya Mchungaji au Wazee wa Kanisa.',
                ])->onlyInput('login');
            }

            Auth::login($user, $request->boolean('remember'));
            if ($request->hasSession()) {
                $request->session()->regenerate();
                if ($user->church_id) {
                    session(['active_church_id' => $user->church_id]);
                }
            }

            AuditService::log('login', "Mtumiaji {$user->name} ({$user->role}) ameingia kwenye mfumo.");

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'login' => 'Barua pepe/nambari ya simu au nenosiri si sahihi.',
        ])->onlyInput('login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $church = Church::where('slug', 'eagt-golani')->first() ?? Church::first();
        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('auth.register', compact('church', 'departments'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:150',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|string|max:50',
            'residential_address' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:100',
            'baptism_status' => 'nullable|string|in:Baptized,Not Baptized',
            'department_id' => 'nullable|exists:departments,id',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'first_name.required' => 'Tafadhali weka jina lako la kwanza.',
            'last_name.required' => 'Tafadhali weka jina lako la pili / ukoo.',
            'phone.required' => 'Tafadhali weka nambari yako ya simu.',
            'gender.required' => 'Tafadhali chagua jinsia yako.',
            'password.required' => 'Tafadhali weka nenosiri salama.',
            'password.min' => 'Nenosiri linapaswa kuwa na herufi zisizopungua 6.',
            'password.confirmed' => 'Nenosiri la kuthibitisha halilingani na uliloliweka mwanzo.',
        ]);

        $rawPhone = trim($validated['phone']);
        $formattedPhone = SmsService::formatTanzanianPhone($rawPhone);
        $localPhone = preg_replace('/^\+255/', '0', $formattedPhone);

        // Check if phone or email already in use
        $existingUserByPhone = User::where('phone', $rawPhone)
            ->orWhere('phone', $formattedPhone)
            ->orWhere('phone', $localPhone)
            ->first();

        if ($existingUserByPhone) {
            return back()->withErrors([
                'phone' => 'Nambari hii ya simu tayari imesajiliwa kwenye mfumo. Unaweza kuingia moja kwa moja kwa namba hii na nenosiri lako.',
            ])->withInput();
        }

        $email = !empty($validated['email']) ? strtolower(trim($validated['email'])) : null;
        if ($email) {
            if (User::where('email', $email)->exists()) {
                return back()->withErrors([
                    'email' => 'Barua pepe hii tayari inatumika. Tafadhali tumia barua pepe nyingine au ingia moja kwa moja.',
                ])->withInput();
            }
        } else {
            // Generate official member email placeholder for church database records
            $cleanFirst = preg_replace('/[^a-z0-9]/', '', strtolower($validated['first_name']));
            $cleanLast = preg_replace('/[^a-z0-9]/', '', strtolower($validated['last_name']));
            $cleanPhoneSuffix = substr(preg_replace('/[^0-9]/', '', $formattedPhone), -4);
            $email = "{$cleanFirst}.{$cleanLast}{$cleanPhoneSuffix}@mshirika.eagt.org";

            $counter = 1;
            while (User::where('email', $email)->exists()) {
                $email = "{$cleanFirst}.{$cleanLast}{$cleanPhoneSuffix}{$counter}@mshirika.eagt.org";
                $counter++;
            }
        }

        $church = Church::where('slug', 'eagt-golani')->first() ?? Church::first();

        DB::beginTransaction();
        try {
            // Generate next member number for this church
            $totalMembers = Member::withoutGlobalScope('church')->where('church_id', $church->id)->count();
            $num = $totalMembers + 1;
            do {
                $memberNumber = 'EAGT-MBR-' . str_pad($num, 4, '0', STR_PAD_LEFT);
                $num++;
            } while (Member::withoutGlobalScope('church')->where('church_id', $church->id)->where('member_number', $memberNumber)->exists());

            // 1. Create Member record in church database
            $member = Member::create([
                'church_id' => $church->id,
                'member_number' => $memberNumber,
                'first_name' => trim($validated['first_name']),
                'last_name' => trim($validated['last_name']),
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'marital_status' => $validated['marital_status'] ?? 'Single',
                'phone' => $formattedPhone,
                'email' => $email,
                'residential_address' => $validated['residential_address'] ?? null,
                'occupation' => $validated['occupation'] ?? null,
                'baptism_status' => $validated['baptism_status'] ?? 'Not Baptized',
                'membership_status' => 'Active',
                'joined_date' => now()->toDateString(),
            ]);

            // 2. Link Department if chosen
            if (!empty($validated['department_id'])) {
                DepartmentMember::create([
                    'church_id' => $church->id,
                    'department_id' => $validated['department_id'],
                    'member_id' => $member->id,
                    'role_in_department' => 'Mwanachama',
                    'joined_at' => now()->toDateString(),
                    'is_active' => true,
                ]);
            }

            // 3. Create User account directly with role 'member'
            $user = User::create([
                'church_id' => $church->id,
                'member_id' => $member->id,
                'department_id' => $validated['department_id'] ?? null,
                'name' => $member->full_name,
                'email' => $email,
                'phone' => $formattedPhone,
                'password' => Hash::make($validated['password']),
                'role' => 'member',
                'status' => 'active',
            ]);

            DB::commit();

            // 4. Audit & notification to leadership
            AuditService::log('created', "Mshirika mpya {$member->full_name} ({$member->member_number}) amejisajili mtandaoni.", 'Member', $member->id);

            AuditService::notifyRole(
                $church->id,
                ['pastor', 'elder', 'secretary'],
                'Mshirika Mpya Amejisajili Mtandaoni',
                "Mshirika mpya {$member->full_name} ({$member->member_number}) amejiunga na EAGT Golani kupitia mfumo.",
                'info',
                route('members.show', $member->id)
            );

            // 5. Send Welcome SMS
            $welcomeMsg = "Bwana Asifiwe {$member->first_name}! Karibu EAGT Golani. Usajili wako kama mshirika umekamilika. Namba yako ya ushirika ni {$member->member_number}.";
            SmsService::send($member->phone, $welcomeMsg, $church->id);

            // Redirect back to login page with pre-filled identifier so user enters credentials to log in
            return redirect()->route('login')
                ->with('success', "Bwana Asifiwe {$member->full_name}! Usajili wako wa ushirika umekamilika kikamilifu. Nambari yako ya Ushirika ni {$member->member_number}. Sasa weka barua pepe au nambari yako ya simu na nenosiri lako hapa chini ili uingie kwenye ukurasa wako.")
                ->with('registered_login', !empty($validated['email']) ? $validated['email'] : $formattedPhone);

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors([
                'registration' => 'Imetokea hitilafu wakati wa kuunda akaunti yako: ' . $e->getMessage(),
            ])->withInput();
        }
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
