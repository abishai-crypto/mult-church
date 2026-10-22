<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Document;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Document::with(['department', 'uploader']);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Access level filtering
        if ($user->isMember()) {
            $query->whereIn('access_level', ['public', 'members']);
        } elseif ($user->isDepartmentLeader()) {
            $query->whereIn('access_level', ['public', 'members', 'department', 'leaders']);
        }

        $documents = $query->latest()->paginate(12)->withQueryString();
        $departments = Department::where('is_active', true)->get();

        $totalDownloads = Document::sum('download_count');
        $totalDocs = Document::count();

        return view('documents.index', compact('documents', 'departments', 'totalDownloads', 'totalDocs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'department_id' => 'nullable|exists:departments,id',
            'access_level' => 'required|in:public,members,department,leaders,admin',
            'description' => 'nullable|string',
            'file' => 'required|file|max:20480', // 20MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $fileName, 'public');

        $document = Document::create([
            'church_id' => session('active_church_id') ?? Auth::user()->church_id,
            'department_id' => $validated['department_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_extension' => strtolower($file->getClientOriginalExtension()),
            'file_size_bytes' => $file->getSize(),
            'access_level' => $validated['access_level'],
            'uploaded_by' => Auth::id(),
            'download_count' => 0,
        ]);

        AuditService::log('created', "Uploaded document: {$document->title}", 'Document', $document->id);

        return back()->with('success', "Document '{$document->title}' uploaded successfully!");
    }

    public function download(Document $document)
    {
        $document->increment('download_count');
        AuditService::log('downloaded', "Downloaded document {$document->title}", 'Document', $document->id);

        $filePath = storage_path('app/public/' . $document->file_path);
        if (file_exists($filePath)) {
            return response()->download($filePath, $document->file_name);
        }

        // Fallback demo response if file not physically on disk
        return response("Document: {$document->title}\nCategory: {$document->category}\nUploaded by: " . ($document->uploader?->name ?? 'Admin'), 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"{$document->title}.txt\"",
        ]);
    }
}
