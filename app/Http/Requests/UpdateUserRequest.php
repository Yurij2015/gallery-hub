<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'phone' => 'required|regex:/^\+[0-9]{3}-[0-9]{3}-[0-9]{4,6}$/',
            'dob' => 'required|date',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string',
            'role' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number must be in the format +123-456-7890..',
        ];
    }
}
