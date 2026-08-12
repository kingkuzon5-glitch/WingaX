<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'owner_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'shop_name' => ['required', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'max:20', 'regex:/^[0-9+\s-]+$/'],
            'location' => ['nullable', 'string', 'max:255'],
        ];
    }
}
