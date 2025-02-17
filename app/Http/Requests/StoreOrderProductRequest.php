<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderProductRequest extends FormRequest
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
            'quantity' => [
                'integer',
                'max:2147483647',
                'min:0',
            ],
            'properties' => [
                'json'
            ],
            'order_id' => [
                'exists:orders,id',
                // 'unique:order_product,order_id',
            ],
            'product_id' => [
                'exists:products,id',
                // 'unique:order_product,product_id',
            ],
        ];

        if ($this->getMethod() == 'POST') {
            array_push($rules['quantity'], 'required');
            array_push($rules['order_id'], 'required');
            array_push($rules['product_id'], 'required');
        }
        return $rules;
    }
    
    public function messages(): array
    {
        return [
            'quantity.required' => 'Поле обязательно для заполнения',
            'order_id.required' => 'Поле обязательно для заполнения',
            'product_id.required' => 'Поле обязательно для заполнения',
            'quantity.integer' => 'Поле должен быть числом',
            'quantity.max' => 'Число должно быть не больше 2147483647',
            'quantity.min' => 'Число должно быть не меньше 0',
            'properties.json' => 'Поле должно быть в формате json',
            'order_id.exists' => 'Такого заказа не существует',
            'product_id.exists' => 'Такого продукта не существует',
        ];
    }
}
