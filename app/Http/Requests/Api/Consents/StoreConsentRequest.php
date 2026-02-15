<?php

namespace App\Http\Requests\Api\Consents;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsentRequest extends FormRequest
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
            'orderNo' => ['required', 'min:3', 'max:30'],
            'amount' => ['required', 'min:2', 'numeric'],
        ];
    }
}
