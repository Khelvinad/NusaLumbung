<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHarvestPoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'commodity' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'target_qty' => ['required', 'numeric', 'min:0.01'],
            'deadline' => ['required', 'date', 'after:today'],
        ];
    }
}
