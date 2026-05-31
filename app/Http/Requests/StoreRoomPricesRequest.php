<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoomPricesRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'pricings' => ['required', 'array', 'size:7'],
            'pricings.*.base_price' => ['required', 'numeric', 'min:0'],
            'pricings.*.vat_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'pricings.*.players' => ['required', 'array'],
            'pricings.*.players.*' => ['required', 'numeric', 'min:0'],
        ];
    }
}
