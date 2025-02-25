<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimesheetRequest;
use App\Http\Requests\UpdateTimesheetRequest;
use App\Models\Timesheet;

class TimesheetController extends Controller
{
    public function index()
    {
        $filters = request()->input('filters', []);
        $projects = Timesheet::filter($filters)->get();

        return response()->json($projects);
    }

    public function store(StoreTimesheetRequest $request)
    {
        $timesheet = Timesheet::create($request->only(['user_id', 'project_id', 'date', 'hours', 'task_name']));

        return response()->json($timesheet, 201);
    }

    public function show(string $id)
    {
        $timesheet = Timesheet::whereId($id)->first();
        if (! $timesheet) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json($timesheet->load(['user', 'project']));
    }

    public function update(UpdateTimesheetRequest $request, Timesheet $timesheet)
    {
        // should timesheet support partial update?
        $data = $request->only(['user_id', 'project_id', 'date', 'hours', 'task_name']);
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $timesheet->$key = $value;
            }
        }
        $timesheet->save();

        // $timesheet->update($request->only(['user_id', 'project_id', 'date', 'hours', 'task_name']));

        return response()->json($timesheet->load(['user', 'project']));
    }

    public function destroy(string $id)
    {
        $timesheet = Timesheet::whereId($id)->first();
        if (! $timesheet) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $timesheet->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
