<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\Member;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    public function index()
    {
        $churches = Church::orderBy('created_at', 'desc')->get();
        $totalChurches = $churches->count();
        $activeChurches = $churches->where('is_active', true)->count();
        $totalUsers = User::withoutGlobalScope('church')->count();
        $totalMembers = Member::withoutGlobalScope('church')->count();

        foreach ($churches as $c) {
            $c->users_count = User::withoutGlobalScope('church')->where('church_id', $c->id)->count();
            $c->members_count = Member::withoutGlobalScope('church')->where('church_id', $c->id)->count();
        }

        return view('superadmin.churches.index', compact(
            'churches',
            'totalChurches',
            'activeChurches',
            'totalUsers',
            'totalMembers'
        ));
    }

    public function create()
    {
        return view('superadmin.churches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:churches,slug',
            'code' => 'nullable|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'currency' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:5',
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
            'subscription_status' => 'required|string',
            'modules' => 'nullable|array',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:6',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        $church = Church::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'code' => $validated['code'] ?? strtoupper(substr($validated['name'], 0, 3)) . '-' . rand(100, 999),
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'currency' => $validated['currency'],
            'currency_symbol' => $validated['currency_symbol'],
            'primary_color' => $validated['primary_color'],
            'secondary_color' => $validated['secondary_color'],
            'subscription_status' => $validated['subscription_status'],
            'subscription_expires_at' => now()->addYear(),
            'modules' => $validated['modules'] ?? ['members', 'finances', 'attendance', 'departments', 'pastoral_care', 'documents', 'media', 'projects', 'assets', 'events'],
            'is_active' => true,
        ]);

        // Create church administrator account
        User::create([
            'church_id' => $church->id,
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => bcrypt($validated['admin_password']),
            'role' => 'church_admin',
            'status' => 'active',
        ]);

        AuditService::log('created', "Provisioned new Church Organization: {$church->name}", 'Church', $church->id);

        return redirect()->route('superadmin.churches.index')->with('success', "Church organization '{$church->name}' provisioned successfully!");
    }

    public function edit(Church $church)
    {
        return view('superadmin.churches.edit', compact('church'));
    }

    public function update(Request $request, Church $church)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'currency' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:5',
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
            'subscription_status' => 'required|string',
            'modules' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $church->update([
            'name' => $validated['name'],
            'tagline' => $validated['tagline'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'currency' => $validated['currency'],
            'currency_symbol' => $validated['currency_symbol'],
            'primary_color' => $validated['primary_color'],
            'secondary_color' => $validated['secondary_color'],
            'subscription_status' => $validated['subscription_status'],
            'modules' => $validated['modules'] ?? [],
            'is_active' => $request->has('is_active'),
        ]);

        AuditService::log('updated', "Updated Church details for {$church->name}", 'Church', $church->id);

        return redirect()->route('superadmin.churches.index')->with('success', "Church '{$church->name}' updated successfully.");
    }

    public function toggleStatus(Church $church)
    {
        $church->is_active = !$church->is_active;
        $church->save();

        $statusText = $church->is_active ? 'activated' : 'suspended';
        AuditService::log('updated', "Church {$church->name} was {$statusText}", 'Church', $church->id);

        return back()->with('success', "Church '{$church->name}' is now {$statusText}.");
    }

    public function switchTenant(Church $church)
    {
        session(['active_church_id' => $church->id]);
        return redirect()->route('dashboard')->with('success', "Switched active context to '{$church->name}'.");
    }

    public function clearTenant()
    {
        session()->forget('active_church_id');
        return redirect()->route('dashboard')->with('info', "Returned to global Super Admin view.");
    }
}
