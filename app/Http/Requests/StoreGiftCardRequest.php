<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGiftCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'allow_mail_delivery'   => $this->boolean('allow_mail_delivery'),
            'allow_post_delivery'   => $this->boolean('allow_post_delivery'),
            'allow_pickup_delivery' => $this->boolean('allow_pickup_delivery'),
        ]);
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
                Rule::unique('gift_cards')
                    ->where(fn($query) => $query->where('escaperoom_id', auth()->user()->escaperoom->id))
                    ->ignore($this->route('id')),
            ],
            'description'           => ['nullable', 'string'],
            'amount'                => ['required', 'numeric', 'min:0'],
            'valid_from'            => ['required', 'date'],
            'valid_until'           => ['nullable', 'date', 'after:valid_from'],
            'shipping_cost'         => ['nullable', 'numeric', 'min:0', 'max:99.99'],
            'allow_mail_delivery'   => ['boolean'],
            'allow_post_delivery'   => ['boolean'],
            'allow_pickup_delivery' => ['boolean'],
            'allow_delivery_method' => [
                function (string $attribute, $value, \Closure $fail) {
                    if (! $this->boolean('allow_mail_delivery')
                        && ! $this->boolean('allow_post_delivery')
                        && ! $this->boolean('allow_pickup_delivery')) {
                        $fail('Kies minstens één bezorgmethode.');
                    }
                },
            ],
        ];
    }
}
