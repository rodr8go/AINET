<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Models\Color;

class ColorFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (strtolower($this->getMethod()) == 'post') {
            return Gate::check('create', Color::class);
        } else {
            return Gate::check('update', $this->route('color'));
        }
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (strtolower($this->getMethod()) == 'post') {
            $this->merge([
                'color' => null,
            ]);
        } else {
            $this->merge([
                'color' => $this->route('color'),
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
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('colors', 'code')->ignore($this->color?->code, 'code')
            ],
        ];
        
        return $rules;
    }
    
    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Color name is required.',
            'code.required' => 'Color code is required.',
            'code.unique' => 'This color code already exists.',
        ];
    }
}