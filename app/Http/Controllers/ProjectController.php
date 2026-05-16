<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()->withCount('components')->latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'figma_file_key' => 'nullable|string|max:255',
        ]);

        $project = auth()->user()->projects()->create($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Project created.');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        $components = $project->components()->latest()->get();
        return view('projects.show', compact('project', 'components'));
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted.');
    }
}
