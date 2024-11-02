<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'total_price' => [
                'decimal:0,2',
                'max:999999999999999999.99',
                'min:0',
                'required',
            ],
                // 'pickup_code' => [
                //     'integer',
                //     'max:99999',
                //     'min:9999',
                //     'required',
                // ],
            'user_id' => [
                'exists:users,id',
                'required',
            ],
        ];

        if ($this->getMethod() == 'POST') {
            array_push($rules['total_price'], 'required');
            array_push($rules['user_id'], 'required');
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'total_price.required' => 'Поле обязательно для заполнения',
            'user_id.required' => 'Поле обязательно для заполнения',
            'total_price.max' => 'Число должно быть не больше 999999999999999999.99',
            'total_price.min' => 'Число должно быть не меньше 0',
            'user_id.exists' => 'Такого пользователя не существует',
        ];
    }
}
