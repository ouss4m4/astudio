<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\AttributeValue;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    public function index()
    {

        $filters = request()->input('filters', []);
        $projects = Project::filter($filters)->with('attributes.attribute', 'users')->get();

        return response()->json($projects);
    }

    public function store(StoreProjectRequest $request)
    {

        $project = Project::create($request->only(['name', 'status']));

        // attributes (eav)
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

        // users if existing
        if ($request->has('users')) {

            $validUsers = User::whereIn('id', $request->input('users'))->pluck('id')->toArray();

            if (count($validUsers) > 0) {
                $project->users()->sync($validUsers);
            }
        }

        return response()->json($project->load(['attributes.attribute', 'users']), 201);
    }

    public function show(string $id)
    {
        $project = Project::whereId($id)->first();
        if (blank($project)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($project->load(['attributes.attribute', 'users']));
    }

    public function update(UpdateProjectRequest $request, Project $project)
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
        }
        // else {
        //     AttributeValue::where('entity_id', $project
        //         ->id)
        //         ->delete();
        // }

        // assign/remove users
        if ($request->has('users')) {
            $userIds = array_map('intval', $request->input('users')); // Ensure integer values
            $validUsers = User::whereIn('id', $userIds)->pluck('id')->toArray();

            if (count($validUsers) > 0) {
                $project->users()->sync($validUsers);
            } elseif ($request->input('users') === []) {
                $project->users()->detach();
            }
        }

        return response()->json($project->load(['attributes.attribute', 'users']));
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
