<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderStatusRequest extends FormRequest
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
            'status_id' => [
                'exists:statuses,id',
                'required',
            ],
            'order_id' => [
                'exists:orders,id',
                'required',
            ],
        ];

        if ($this->getMethod() == 'POST') {
            array_push($rules['status_id'], 'required');
            array_push($rules['order_id'], 'required');
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'Поле обязательно для заполнения',
            'status_id.required' => 'Поле обязательно для заполнения',
            'order_id.exists' => 'Такого заказа не существует',
            'status_id.exists' => 'Такого продукта не существует',
        ];
    }
}
