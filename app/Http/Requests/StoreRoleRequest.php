<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
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
        if ($this->filled('name')) {
            $this->merge(['name' => Str::ucfirst(trim($this->string('name')))]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $roleId = $this->route('role')?->id;

        return [
            'name' => ['required', 'string', 'max:75', Rule::unique('roles', 'name')->ignore($roleId)],
            'permissions' => ['array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ];
    }
}
