<?php

namespace App\Http\Requests\Integrations;

use Illuminate\Foundation\Http\FormRequest;

class StoreIntegrationRequest extends FormRequest
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
            'name' => 'required|min:3',
            'driver' => 'required',
            'redirect_consent' => 'required',
            'webhook_consent' => 'required',
            'redirect_collection' => 'required',
            'webhook_collection' => 'required',
            'authentication_key' => 'required',
        ];
    }
}
