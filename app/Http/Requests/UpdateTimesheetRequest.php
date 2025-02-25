<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateTimesheetRequest extends FormRequest
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
            'user_id' => 'sometimes|exists:users,id',
            'project_id' => 'sometimes|exists:projects,id',
            'date' => 'sometimes|date',
            'hours' => 'sometimes|numeric|min:0',
            'task_name' => 'sometimes|string',
        ];
    }
}
