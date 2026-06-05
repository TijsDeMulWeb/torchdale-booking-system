<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWidgetSettingsRequest extends FormRequest
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
            'widget_color_primary' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'widget_color_primary_dark' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'widget_color_background_dark' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'widget_color_text' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'widget_color_sale' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'widget_color_success' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ];
    }
}
