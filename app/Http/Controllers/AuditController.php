<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->isChurchAdmin() && !$user->isSuperAdmin()) {
            abort(403, 'Unauthorized to view system audit logs.');
        }

        $query = AuditLog::with('user');

        if ($user->isSuperAdmin() && !session()->has('active_church_id')) {
            $query->withoutGlobalScope('church');
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('entity_type', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->latest('created_at')->paginate(20)->withQueryString();

        return view('audit.index', compact('logs'));
    }
}
