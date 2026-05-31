<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
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
            'escaperoom_address_id' => [
                'required',
                'integer',
                Rule::exists('escaperoom_addresses', 'id')->where(function ($query) {
                    $query->where('escaperoom_id', auth()->user()->escaperoom->id);
                }),
            ],
            'duration' => ['required', 'integer', 'min:15'],
            'min_players' => ['required', 'integer', 'min:1'],
            'max_players' => ['required', 'integer', 'min:2', 'gt:min_players'],
            'min_age' => ['required', 'integer', 'min:0'],
            'url' => ['nullable', 'image', 'max:5120'],
            'active_from' => ['required', 'date'],
            'active_until' => ['nullable', 'date', 'after:active_from'],
            'max_booking_advance' => ['nullable', 'integer', 'min:0'],
            'color' => ['required', 'string', 'max:7']
        ];
    }
}
