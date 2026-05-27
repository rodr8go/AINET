<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Models\TshirtImage;

class TshirtImageFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (strtolower($this->getMethod()) == 'post') {
            // Check if creating catalog image or custom image
            $isCatalog = $this->route()->getName() === 'catalog-images.store';
            
            if ($isCatalog) {
                return Gate::check('createCatalog', TshirtImage::class);
            }
            
            return Gate::check('createCustom', TshirtImage::class);
        } else {
            return Gate::check('update', $this->route('tshirtImage'));
        }
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (strtolower($this->getMethod()) == 'post') {
            $this->merge([
                'tshirtImage' => null,
            ]);
        } else {
            $this->merge([
                'tshirtImage' => $this->route('tshirtImage'),
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
            'description' => 'nullable|string|max:1000',
        ];
        
        // Category is only for catalog images
        if ($this->route()->getName() === 'catalog-images.store' || 
            $this->route()->getName() === 'catalog-images.update') {
            $rules['category_id'] = 'nullable|exists:categories,id';
        }
        
        // Image rules
        if (strtolower($this->getMethod()) == 'post') {
            $rules['image_file'] = 'required|image|max:5120';
        } else {
            $rules['image_file'] = 'sometimes|image|max:5120';
        }
        
        return $rules;
    }
    
    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Image name is required.',
            'image_file.required' => 'Please select an image file.',
            'image_file.image' => 'The file must be an image.',
            'image_file.max' => 'The image cannot exceed 5MB.',
            'category_id.exists' => 'Selected category does not exist.',
        ];
    }
}