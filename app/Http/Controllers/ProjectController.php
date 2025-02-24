<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {

        return Project::with('attributes.attribute')->thisUser()->get();
    }

    // TODO: add request validation
    public function store(Request $request)
    {
        $project = Project::create($request->only(['name', 'status']));

        if ($request->has('attributes') && count($request->input('attributes')) > 0) {
            foreach ($request->input('attributes') as $attr) {
                if (isset($attr['id']) && isset($attr['value'])) {
                    AttributeValue::create([
                        'attribute_id' => $attr['id'],
                        'entity_id' => $project->id,
                        'value' => $attr['value'],
                    ]);
                }
            }
        }

        return response()->json($project->load('attributes.attribute'), 201);
    }

    public function show(string $id)
    {
        $project = Project::whereId($id)->first();
        if (blank($project)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($project->load('attributes.attribute'));
    }

    // TODO: add request validation
    public function update(Request $request, Project $project)
    {
        $project->update($request->only(['name', 'status']));

        // TODO: edge case, if no attributes are sent. should we remove existing?
        if ($request->has('attributes') && count($request->input('attributes')) > 0) {
            foreach ($request->input('attributes') as $attr) {
                if (isset($attr['id']) && isset($attr['value'])) {
                    AttributeValue::updateOrCreate(
                        ['attribute_id' => $attr['id'], 'entity_id' => $project->id],
                        ['value' => $attr['value']]
                    );
                }
            }
        } else {
            AttributeValue::where('entity_id', $project
                ->id)
                ->delete();
        }

        return response()->json($project->load('attributes.attribute'));
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
