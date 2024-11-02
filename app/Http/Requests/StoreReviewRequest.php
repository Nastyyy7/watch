<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'content' => [
                'string',
            ],
            'rating' => [
                'integer',
                'max:5',
                'min:1',              
            ],
            'order_product_id' => [
                'exists:order_product,id',
            ],
        ];

        if ($this->getMethod() == 'POST') {
            array_push($rules['rating'], 'required');
            array_push($rules['order_product_id'], 'required');
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Поле обязательно для заполнения',
            'order_product_id.required' => 'Поле заказанного продукта обязательно для заполнения',
            'content.string' => 'Поле должен быть строкой',
            'rating.max' => 'Число должно быть не больше 5',
            'rating.min' => 'Число должно быть не меньше 1',
            'order_product_id.exists' => 'Такого заказанного продукта не существует',
        ];
    }
}
