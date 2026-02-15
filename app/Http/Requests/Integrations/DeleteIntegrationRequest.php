<?php

namespace App\Http\Requests\Integrations;

use Illuminate\Foundation\Http\FormRequest;

class DeleteIntegrationRequest extends FormRequest
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
            'confirm_name' => [
                'required',
                function ($attribute, $value, $fail): void {
                    $application = $this->route('application');

                    if (! $application || $value !== $application->name) {
                        $fail('The application name does not match.');
                    }
                },
            ],

        ];
    }
}
