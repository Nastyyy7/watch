<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
                'max:105',
                'string',
            ],
            'photo' => [
                'image',
                'max:5120',
                'mimes:gif,jpeg,png,webp',
                'min:1', 
            ],
            'price' => [
                // проверить можно ли добавить разные варианты после запятой
                'decimal:0,2',
                'max:999999999.99',
                'min:0',
            ],
            'properties' => [
                'json'
            ],
            'quantity' => [
                'integer',
                'max:2147483647',
                'min:0',
            ],
            // потестить на 0 на null на любые данные, на 1
            'available' => [
                // 'boolean',
            ],
            'type_id' => [
                'exists:types,id',

            ],
        ];

        if ($this->getMethod() == 'POST') {
            array_push($rules['name'], 'required');
            array_push($rules['photo'], 'required');
            array_push($rules['price'], 'required');
            array_push($rules['quantity'], 'required');
            array_push($rules['type_id'], 'required');
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле имени обязательно для заполнения',
            'name.string' => 'Имя должен быть строкой',
            'name.max' => 'Поле должно быть не длиннее 105',
            'photo.required' => 'Поле обязательно для заполнения',
            'photo.image' => 'Картинка должен быть картинкой',
            'photo.max' => 'Картинка должно быть не больше 5120 КиБ',
            'photo.mimes' => 'Картинка должно быть форматов gif,jpeg,png,webp',
            'price.required' => 'Поле обязательно для заполнения',
            'price.decimal' => 'В поле должно быть 2 числа после запятой',
            'price.max' => 'Поле должно быть не больше 999999999.99',
            'properties.json' => 'Поле должно быть в формате json',
            'quantity.integer' => 'Поле должно быть в числовом формате',
            'quantity.max' => 'Поле должно быть не больше 2147483647',
            'quantity.required' => 'Поле обязательно для заполнения',
            'available.boolean' => 'Поле должно были, либо true/false, либо 1/0, соответсенно',
            'type_id.required' => 'Поле обязательно для заполнения',
            'type_id.exists' => 'Такого типа не существует',
        ];
    }
}
