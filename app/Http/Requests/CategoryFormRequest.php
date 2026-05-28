<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Models\Category;

class CategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (strtolower($this->getMethod()) == 'post') {
            return Gate::check('create', Category::class);
        } else {
            return Gate::check('update', $this->route('category'));
        }
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (strtolower($this->getMethod()) == 'post') {
            $this->merge([
                'category' => null,
            ]);
        } else {
            $this->merge([
                'category' => $this->route('category'),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($this->category?->id)
            ],
            'image_file' => 'sometimes|image|max:2048',
        ];
        
        // For create, image is required
        if (strtolower($this->getMethod()) == 'post') {
            $rules['image_file'] = 'required|image|max:2048';
        }
        
        return $rules;
    }
    
    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.unique' => 'This category name already exists.',
            'image_file.required' => 'Please select an image for the category.',
            'image_file.image' => 'The file must be an image.',
            'image_file.max' => 'The image cannot exceed 2MB.',
        ];
    }
}