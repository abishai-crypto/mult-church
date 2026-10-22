<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Services\AuditService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordSecurityController extends Controller
{
    /**
     * Display church password security and ecclesiastical oversight console.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();

        if (!$currentUser->canManagePasswords()) {
            abort(403, 'Ni Mchungaji Kiongozi, Wazee wa Kanisa na Wasimamizi pekee wenye mamlaka ya kikanisa ya kusimamia manenosiri.');
        }

        $query = User::with('department');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('name')->paginate(15)->withQueryString();

        // Maombi ya kurejesha nenosiri yanayosubiri uthibitisho wa Wazee/Mchungaji
        $pendingRequests = PasswordResetRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $recentResets = PasswordResetRequest::with(['user', 'handledBy'])
            ->where('status', '!=', 'pending')
            ->latest('handled_at')
            ->take(10)
            ->get();

        return view('security.passwords.index', compact(
            'users',
            'pendingRequests',
            'recentResets',
            'currentUser'
        ));
    }

    /**
     * Ecclesiastical password reset by Pastor / Elders / Admin.
     */
    public function resetUserPassword(Request $request, User $user)
    {
        $currentUser = Auth::user();

        if (!$currentUser->canResetPasswordFor($user)) {
            return back()->withErrors(['error' => "Usalama wa Kikanisa: Huna mamlaka ya kikanisa ya kurejesha nenosiri la mtumiaji mwenye jukumu la '{$user->role}'. Mchungaji Kiongozi au Msimamizi Mkuu pekee ndiye anayeweza."]);
        }

        $request->validate([
            'new_password' => 'required|string|min:6',
            'send_sms' => 'nullable|boolean',
            'notes' => 'nullable|string|max:255',
        ]);

        $newPassword = $request->new_password;
        $user->password = Hash::make($newPassword);
        $user->save();

        $roleLabels = [
            'pastor' => 'Mchungaji Kiongozi',
            'elder' => 'Mzee wa Kanisa',
            'super_admin' => 'Msimamizi Mkuu',
            'church_admin' => 'Msimamizi wa Kanisa',
        ];
        $operatorRole = $roleLabels[$currentUser->role] ?? 'Kiongozi wa Kanisa';

        // Tuma SMS ya taarifa kama namba ya simu ipo na kiongozi amechagua kutuma
        $smsSent = false;
        if ($user->phone && $request->boolean('send_sms', true)) {
            $churchName = $user->church?->name ?? 'EAGT Golani';
            $smsMsg = "Bwana Asifiwe {$user->name}! Nenosiri lako la kuingilia mfumo wa {$churchName} limerejeshwa na {$operatorRole} ({$currentUser->name}). Nenosiri lako jipya: {$newPassword}. Tafadhali ingia na ubadilishe.";
            SmsService::send($user->phone, $smsMsg, $user->church_id);
            $smsSent = true;
        }

        // Rekodi kumbukumbu ya ukaguzi (Audit Log)
        AuditService::log(
            'security',
            "{$operatorRole} ({$currentUser->name}) amerejesha nenosiri la mtumiaji '{$user->name}' ({$user->email}, Role: {$user->role}) kwa kufuata taratibu za kikanisa." . ($request->notes ? " Sababu: {$request->notes}" : ""),
            'User',
            $user->id
        );

        $msg = "Nenosiri la {$user->name} limerejeshwa kikamilifu kuwa: '{$newPassword}'.";
        if ($smsSent) {
            $msg .= " Mhusika ametumiwa SMS ya nenosiri kwenye simu yake ({$user->phone}).";
        }

        return back()->with('success', $msg);
    }

    /**
     * Approve a public password reset request.
     */
    public function approveRequest(Request $request, PasswordResetRequest $resetRequest)
    {
        $currentUser = Auth::user();

        $user = $resetRequest->user ?? User::where('email', $resetRequest->email)->first();

        if ($user && !$currentUser->canResetPasswordFor($user)) {
            return back()->withErrors(['error' => "Huna mamlaka ya kikanisa ya kuidhinisha ombi la mtumiaji mwenye jukumu hili."]);
        }

        $tempPassword = 'Eagt@' . rand(1000, 9999);

        if ($user) {
            $user->password = Hash::make($tempPassword);
            $user->save();
        }

        $resetRequest->update([
            'status' => 'approved',
            'handled_by' => $currentUser->id,
            'handled_at' => now(),
            'admin_notes' => $request->get('notes', "Limeidhinishwa kikanisa na {$currentUser->name}."),
        ]);

        $recipientPhone = $resetRequest->phone ?? $user?->phone;
        if ($recipientPhone) {
            $name = $resetRequest->requester_name ?? ($user?->name ?? 'Mshirika');
            $msg = "Bwana Asifiwe {$name}! Ombi lako la kurejesha nenosiri la kanisa limeidhinishwa na Wazee wa Kanisa/Mchungaji. Nenosiri lako jipya la muda ni: {$tempPassword}. Ingia na ubadilishe.";
            SmsService::send($recipientPhone, $msg, $resetRequest->church_id);
        }

        AuditService::log(
            'security',
            "Mzee wa Kanisa / Mchungaji ({$currentUser->name}) ameidhinisha ombi la kurejesha nenosiri kwa {$resetRequest->email}.",
            'PasswordResetRequest',
            $resetRequest->id
        );

        return back()->with('success', "Ombi la kurejesha nenosiri kwa '{$resetRequest->email}' limeidhinishwa na nenosiri jipya ({$tempPassword}) limewekwa.");
    }

    /**
     * Reject a public password reset request.
     */
    public function rejectRequest(Request $request, PasswordResetRequest $resetRequest)
    {
        $currentUser = Auth::user();

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $resetRequest->update([
            'status' => 'rejected',
            'handled_by' => $currentUser->id,
            'handled_at' => now(),
            'admin_notes' => $request->reason,
        ]);

        AuditService::log(
            'security',
            "Ombi la kurejesha nenosiri kwa {$resetRequest->email} limekataliwa na {$currentUser->name}. Sababu: {$request->reason}",
            'PasswordResetRequest',
            $resetRequest->id
        );

        return back()->with('warning', "Ombi la kurejesha nenosiri kwa '{$resetRequest->email}' limekataliwa.");
    }
}
