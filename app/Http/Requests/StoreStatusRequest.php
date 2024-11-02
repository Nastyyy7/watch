<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStatusRequest extends FormRequest
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
            'name' => [
                'max:55',
                'string',
                'unique:statuses,name',
            ],
        ];

        if ($this->getMethod() == 'POST') {
            array_push($rules['name'], 'required');
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле имени обязательно для заполнения',
            'name.string' => 'Имя должен быть строкой',
            'name.max' => 'Поле должно быть не длиннее 55',
            'name.unique' => 'Такое имя уже существует',
        ];
    }
}
