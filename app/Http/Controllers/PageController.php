<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function home()
    {
        // pass recent projects that have a stored file
        $all = Project::latest()->take(6)->get();
        $projects = $all->filter(function ($p) {
            return $p->file_path && Storage::disk('public')->exists($p->file_path);
        })->values()->take(3);

        return view('home', compact('projects'));
    }

    public function about()
    {
        return view('about');
    }

    public function projects()
    {
        // redirect to ProjectController@index could be used too, but we'll show projects here
        $projects = Project::latest()->get();
        return view('projects', compact('projects'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function storeContact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required'
        ]);

        Message::create($data);

        return back()->with('success', 'Message Sent Successfully!');
    }
}
