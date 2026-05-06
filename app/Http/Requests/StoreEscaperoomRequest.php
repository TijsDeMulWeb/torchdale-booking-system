<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
                'exists:escaperooms,name'
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
                'exists:escaperooms,email'
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
        ];
    }
}
