<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Project;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('assets')->orderBy('created_at', 'desc')->get();

        $totalEstimated = Project::sum('estimated_cost');
        $totalRaised = Project::sum('raised_amount');
        $totalSpent = Project::sum('spent_amount');

        return view('projects.index', compact('projects', 'totalEstimated', 'totalRaised', 'totalSpent'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_type' => 'required|in:building,land,renovation,equipment,expansion',
            'estimated_cost' => 'required|numeric|min:0',
            'raised_amount' => 'nullable|numeric|min:0',
            'spent_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'target_completion_date' => 'nullable|date',
            'status' => 'required|in:planning,in_progress,on_hold,completed',
            'location' => 'nullable|string|max:255',
            'leader_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project = Project::create(array_merge($validated, [
            'raised_amount' => $validated['raised_amount'] ?? 0,
            'spent_amount' => $validated['spent_amount'] ?? 0,
            'created_by' => Auth::id(),
        ]));

        AuditService::log('created', "Created project {$project->title}", 'Project', $project->id);

        return back()->with('success', "Project '{$project->title}' created successfully.");
    }

    public function assets()
    {
        $assets = Asset::with('project')->orderBy('category')->paginate(15);
        $projects = Project::all();

        $totalAssetValue = Asset::sum('current_value') ?: Asset::sum('purchase_price');
        $totalAssetCount = Asset::count();

        return view('projects.assets', compact('assets', 'projects', 'totalAssetValue', 'totalAssetCount'));
    }

    public function storeAsset(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'project_id' => 'nullable|exists:projects,id',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'current_value' => 'nullable|numeric|min:0',
            'condition' => 'required|in:new,good,fair,needs_repair,disposed',
            'location' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:100',
            'warranty_info' => 'nullable|string',
            'maintenance_notes' => 'nullable|string',
        ]);

        $assetCode = 'AST-' . strtoupper(substr($validated['category'], 0, 3)) . '-' . rand(100, 999);

        $asset = Asset::create(array_merge($validated, [
            'asset_code' => $assetCode,
        ]));

        AuditService::log('created', "Registered asset: {$asset->name} ({$asset->asset_code})", 'Asset', $asset->id);

        return back()->with('success', "Asset '{$asset->name}' registered with Code: {$asset->asset_code}.");
    }
}
