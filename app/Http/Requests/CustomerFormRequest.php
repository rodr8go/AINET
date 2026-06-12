<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Models\Customer;

class CustomerFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (strtolower($this->getMethod()) == 'post') {
            return Gate::check('create', Customer::class);
        } else {
            return Gate::check('update', $this->route('customer'));
        }
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Adds the customer information to the Request for unique rule
        if (strtolower($this->getMethod()) == 'post') {
            $this->merge([
                'customer' => null,
            ]);
        } else {
            $this->merge([
                'customer' => $this->route('customer'),
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
                Rule::unique('users', 'email')->ignore($this->customer?->id)
            ],
            'gender' => 'required|in:M,F',
            'nif' => 'nullable|digits:9',
            'address' => 'nullable|string|max:500',
            'default_payment_type' => 'nullable|in:Visa,PayPal,MB WAY',
            'default_payment_ref' => 'nullable|string|max:255',
            'photo_file' => 'sometimes|image|max:4096',
        ];
        
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
            'nif.digits' => 'NIF must have exactly 9 digits.',
            'default_payment_type.in' => 'Payment type must be Visa, PayPal, or MB.',
        ];
    }
}