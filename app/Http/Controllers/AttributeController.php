<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function index()
    {
        return Attribute::all();
    }

    public function show(string $id)
    {
        $attribute = Attribute::whereId($id)->get();
        if (blank($attribute)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($attribute);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:text,date,number,select',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return Attribute::create($request->only(['name', 'type']));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $attribute->update($request->only(['name', 'type']));

        return response()->json($attribute);
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
