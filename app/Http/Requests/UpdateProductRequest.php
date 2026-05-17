<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(array_filter([
            'name' => $this->has('name') ? strip_tags($this->name) : null,
            'description' => $this->has('description') ? strip_tags($this->description) : null,
        ], fn ($v) => $v !== null));
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'required', 'integer', 'min:0'],
            'category' => ['sometimes', 'required', 'string', Rule::in(Product::CATEGORIES)],
            'photo' => ['sometimes', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
