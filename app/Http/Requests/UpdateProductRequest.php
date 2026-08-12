<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('product')) ?? false;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'availability' => ['required', 'in:in_stock,limited,out_of_stock'],
            'is_featured' => ['nullable', 'boolean'],
            'is_deal' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
            'spec_labels' => ['nullable', 'array'],
            'spec_labels.*' => ['nullable', 'string', 'max:100'],
            'spec_values' => ['nullable', 'array'],
            'spec_values.*' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'array', 'max:8'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video' => ['nullable', 'file', 'mimes:mp4,webm', 'max:51200'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($this->filled('discount_price') && (float) $this->input('discount_price') >= (float) $this->input('price')) {
                $validator->errors()->add('discount_price', 'The discount price must be lower than the regular price.');
            }
        });
    }
}
