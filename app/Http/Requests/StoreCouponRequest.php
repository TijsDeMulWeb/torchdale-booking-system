<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCouponRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons')->where(
                    fn($query) =>
                    $query->where('escaperoom_id', auth()->user()->escaperoom->id)
                ),
            ],
            'discount_type' => ['required', 'in:fixed,percentage'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'valid_from' => ['required', 'date', 'before:valid_until'],
            'valid_until' => ['nullable', 'date', 'after:valid_from'],
        ];
    }
}
