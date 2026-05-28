<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (strtolower($this->getMethod()) == 'post') {
            return Gate::check('create', User::class);
        } else {
            return Gate::check('update', $this->route('user'));
        }
    }

    /**
     * Prepare the data for validation.
     * This runs before validation rules are applied.
     */
    protected function prepareForValidation(): void
    {
        // Adds the user information to the Request for unique rule
        if (strtolower($this->getMethod()) == 'post') {
            $this->merge([
                'user' => null,
            ]);
        } else {
            $this->merge([
                'user' => $this->route('user'),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user?->id)
            ],
            'gender' => 'required|in:M,F',
            'user_type' => 'required|in:F,A',  // Employee or Admin
            'photo_file' => 'sometimes|image|max:4096', // 4Mb max
        ];
        
        // Only admins can set the admin flag
        if (Gate::check('createAdmin', User::class)) {
            $rules['admin'] = 'boolean';
        }
        
        return $rules;
    }
    
    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'gender.required' => 'Please select a gender.',
            'user_type.required' => 'Please select a user type.',
            'user_type.in' => 'User type must be Employee (F) or Admin (A).',
            'photo_file.image' => 'The file must be an image.',
            'photo_file.max' => 'The image cannot exceed 4MB.',
        ];
    }
}