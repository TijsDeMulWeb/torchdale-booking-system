<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'shipping_cost_domestic'      => $this->shipping_cost_domestic      !== '' ? $this->shipping_cost_domestic      : 0,
            'shipping_cost_international' => $this->shipping_cost_international !== '' ? $this->shipping_cost_international : 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:product_categories,id'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'shipping_cost_domestic' => ['required', 'numeric', 'min:0'],
            'shipping_cost_international' => ['required', 'numeric', 'min:0'],
            'vat_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'discount_type' => ['nullable', 'in:fixed,percentage'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', 'max:50', 'unique:products,sku,' . $this->route('id')],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'available_from' => ['required', 'date'],
        ];
    }
}
