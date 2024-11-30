<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:2|confirmed';
        }
        return $rules;
    }

    public function messages(): array
    {
        // dd("hello");
        return [
            'email' => 'The email address is required.',
            // 'email.email' => 'Please enter a valid email address.',
            // 'email.unique' => 'This email address is already taken.',
        ];
    }
}
