<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        $rules = [
            'name' => [
                'max:255',
                'string',
            ],
            'email' => [
                'max:255',
                'string',
                'unique:users,email',
            ],
            'password' => [
                'max:255',
                'string',
            ],
        ];

        if ($this->getMethod() == 'POST') {
            array_push($rules['name'], 'required');
            array_push($rules['email'], 'required');
            array_push($rules['password'], 'required');
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле имени обязательно для заполнения',
            'email.required' => 'Поле почты обязательно для заполнения',
            'password.required' => 'Поле пароля обязательно для заполнения',
            'email.unique' => 'Такой пользователь уже существует',
        ];
    }
}
