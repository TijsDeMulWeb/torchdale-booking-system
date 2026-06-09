<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreManualBookingRequest extends FormRequest
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
            'room_id'       => ['required', 'integer'],
            'date'          => ['required', 'date_format:Y-m-d'],
            'start'         => ['required', 'date_format:H:i'],
            'end'           => ['required', 'date_format:H:i'],
            'players'       => ['required', 'integer', 'min:1'],
            'language_id'   => ['required', 'integer', 'exists:languages,id'],
            'custom_price'  => ['nullable', 'numeric', 'min:0'],
            'amount_online' => ['nullable', 'numeric', 'min:0'],
            'amount_onsite' => ['nullable', 'numeric', 'min:0'],
            'first_name'    => ['required', 'string', 'max:75'],
            'last_name'     => ['required', 'string', 'max:75'],
            'email'         => ['required', 'email', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'street'        => ['nullable', 'string', 'max:100'],
            'house_number'  => ['nullable', 'string', 'max:20'],
            'postal_code'   => ['nullable', 'string', 'max:20'],
            'city'          => ['nullable', 'string', 'max:100'],
        ];
    }
}
