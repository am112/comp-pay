<?php

namespace App\Http\Requests\Api\Collections;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchCollectionRequest extends FormRequest
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
            'invoices' => ['required'],
            'invoices.*.orderNo' => ['required', 'string'],
            'invoices.*.invoiceNo' => ['required', 'string'],
            'invoices.*.description' => ['required', 'string'],
            'invoices.*.amount' => ['required', 'integer', 'min:1'],
        ];
    }
}
