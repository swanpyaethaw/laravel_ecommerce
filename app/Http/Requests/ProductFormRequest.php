<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category_id' => [
                'required',
                'integer'
            ],
            'name' => [
                'required',
                'string'
            ],
            'slug' => [
                'required',
                'string'
            ],
            'brand' => [
                'nullable',
                'string'
            ],
            'small_description' => [
                'nullable',
                'string'
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'meta_title' => [
                'nullable',
                'string'
            ],
            'meta_keyword' => [
                'nullable',
                'string'
            ],
            'meta_description' => [
                'nullable',
                'string'
            ],
            'original_price' => [
                'required',
                'integer',
                'min:1'
            ],
            'selling_price' => [
                'required',
                'integer',
            ],
            'quantity' => [
                'required',
                'integer',
            ],
            'trend' => [
                'nullable'
            ],
            'status' => [
                'nullable'
            ],
            // 'image' => [
            //     'nullable',
            // ],
            'image.*' => [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg'
            ],
            'colors.*' => [
                'nullable'
            ],
            'color_quantity.*'=> [
                'nullable',
                'integer',
                'min:0'
            ]


        ];
    }
}
