<?php

namespace App\Http\Requests\Central\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'domain' => 'required|string|max:255|unique:domains,domain',
            'email' => 'required|email|max:255|unique:users,email',
            // 'phone' => 'required|string|max:255',
            'is_free' => 'required|boolean',
        ];
    }
}
