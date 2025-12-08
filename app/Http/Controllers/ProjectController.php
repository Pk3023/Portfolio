<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProjectController extends Controller
{
    public function index()
    {
        // Only show projects that have a stored folder file and where the file exists on disk
        $all = Project::latest()->get();
        $projects = $all->filter(function ($p) {
            return $p->file_path && Storage::disk('public')->exists($p->file_path);
        })->values();

        return view('projects', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_link' => 'nullable|url',
            'image' => 'nullable|image|max:4096',
            // allow up to 100MB zip uploads (value in kilobytes)
            'folder' => 'nullable|mimes:zip|max:102400'
        ]);

        // handle image (store on public disk)
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $path = $img->store('projects/images', 'public');
            // $path is like "projects/images/xxxx.jpg"
            $data['image_path'] = $path;
        }

        // handle folder (zip) and save on public disk
        if ($request->hasFile('folder')) {
            $folder = $request->file('folder');
            $path = $folder->store('projects/folders', 'public');
            $data['file_path'] = $path;
        }

        Project::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'project_link' => $data['project_link'] ?? null,
            'image_path' => $data['image_path'] ?? null,
            'file_path' => $data['file_path'] ?? null,
        ]);

        return redirect()->route('projects')->with('success', 'Project uploaded successfully!');
    }

    /**
     * Secure download for project folder zip.
     * Streams file from storage/app/public/... ensuring correct path and existence.
     */
    public function download($id)
    {
        $project = Project::findOrFail($id);
        if (! $project->file_path) {
            abort(404);
        }

        $relative = $project->file_path; // stored relative to storage/app/public
        $full = storage_path('app/public/' . $relative);
        if (! file_exists($full)) {
            abort(404);
        }

        return response()->download($full, basename($full));
    }
}
