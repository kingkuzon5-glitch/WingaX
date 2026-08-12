<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('tags_input')) {
            $tags = collect(explode(',', $this->string('tags_input')))
                ->map(fn ($tag) => trim($tag))
                ->filter()
                ->values()
                ->all();

            $this->merge(['tags' => $tags]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'location' => ['nullable', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'max:20', 'regex:/^[0-9+\s-]+$/'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }
}
