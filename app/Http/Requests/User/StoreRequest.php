<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:80'],
            'mobile' => ['required', 'string', 'min:2', 'max:20', 'regex:/^[+]?[\d]+$/i'],
        ];
    }

    public function messages()
    {
        return [
            'mobile.regex' => 'The mobile number is invalid. (use only + and numbers)',
        ];
    }
}
