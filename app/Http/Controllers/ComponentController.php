<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Project;
use App\Services\FigmaUrlParser;
use App\Services\N8nWebhookService;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function library()
    {
        $components = Component::whereHas('project', fn ($q) => $q->where('user_id', auth()->id()))
            ->with('project')
            ->latest()
            ->paginate(24);

        return view('component-library', compact('components'));
    }

    public function create(Project $project)
    {
        $this->authorize('view', $project);
        return view('components.create', compact('project'));
    }

    public function store(Request $request, Project $project, FigmaUrlParser $parser, N8nWebhookService $n8n)
    {
        $this->authorize('view', $project);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'figma_url' => 'required|url',
            'framework' => 'required|in:react,vue',
        ]);

        $parsed = $parser->parse($validated['figma_url']);

        $component = $project->components()->create([
            'name'          => $validated['name'],
            'figma_url'     => $validated['figma_url'],
            'figma_node_id' => $parsed['node_id'],
            'framework'     => $validated['framework'],
            'status'        => 'pending',
        ]);

        $figmaToken = auth()->user()->figma_access_token;

        if ($figmaToken) {
            $component->update(['status' => 'processing']);
            $component->logs()->create(['status' => 'processing']);
            $n8n->trigger($component, $figmaToken);
        }

        return redirect()->route('components.show', $component)->with('success', 'Component submitted for generation.');
    }

    public function show(Component $component)
    {
        $this->authorize('view', $component->project);
        $component->load('logs', 'project');
        return view('components.show', ['item' => $component]);
    }

    public function status(Component $component)
    {
        $this->authorize('view', $component->project);
        return response()->json(['status' => $component->status]);
    }

    public function destroy(Component $component)
    {
        $this->authorize('delete', $component->project);
        $project = $component->project;
        $component->delete();
        return redirect()->route('projects.show', $project)->with('success', 'Component deleted.');
    }
}
