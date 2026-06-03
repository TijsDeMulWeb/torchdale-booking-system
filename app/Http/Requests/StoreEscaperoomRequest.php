<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEscaperoomRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('escaperooms', 'name')->ignore(auth()->user()->escaperoom_id),
            ],
            'phone' => [
                'required',
                'string',
                'max:15'
            ],
            'email' => [
                'required',
                'string',
                'max:150',
                'email',
            ],
            'allowed_origin' => [
                'nullable',
                'string',
                'max:200',
                'starts_with:https://'
            ],
            'invoice_email' => [
                'nullable',
                'string',
                'max:150',
                'email',
            ],
            'vat_number' => [
                'required',
                'string',
                'max:20'
            ],
            'registration_number' => [
                'nullable',
                'string',
                'max:20'
            ],
            'logo' => [
                'nullable',
                'image',
                'max:2048',
            ],
            'mollie_api_key' => [
                'nullable',
                'string',
            ],
            'openai_api_key' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function escaperoomData(): array
    {
        return $this->only([
            'name',
            'phone',
            'email',
            'invoice_email',
            'vat_number',
            'registration_number',
            'logo'
        ]);
    }

    public function escaperoomSettingsData(): array
    {
        return $this->only([
            'allowed_origin',
            'mollie_api_key',
            'openai_api_key',
        ]);
    }
}
