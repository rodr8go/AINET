<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Price;

class PriceFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::check('update', Price::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'unit_price_catalog' => 'required|numeric|min:0|max:999999.99',
            'unit_price_own' => 'required|numeric|min:0|max:999999.99',
            'unit_price_catalog_discount' => 'required|numeric|min:0|max:999999.99',
            'unit_price_own_discount' => 'required|numeric|min:0|max:999999.99',
            'qty_discount' => 'required|integer|min:1|max:1000',
        ];
    }
    
    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'unit_price_catalog.required' => 'Catalog unit price is required.',
            'unit_price_catalog.numeric' => 'Catalog unit price must be a number.',
            'qty_discount.required' => 'Quantity discount threshold is required.',
            'qty_discount.integer' => 'Quantity discount threshold must be a whole number.',
        ];
    }
}