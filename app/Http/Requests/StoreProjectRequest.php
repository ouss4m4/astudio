<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(
            $validator,
            response()->json(['errors' => $validator->errors()], 422)
        );
    }

    public function rules(): array
    {

        return [
            'name' => 'required|string|max:255',
            'status' => 'required|in:todo,progress,done',
            'attributes' => 'array',
            'attributes.*.id' => 'required_with:attributes|exists:attributes,id',
            'attributes.*.value' => 'required_with:attributes|string|max:255',
            'users' => 'sometimes|array',
            'users.*' => 'exists:users,id',
        ];
    }
}
