<?php

namespace App\Http\Requests\CustomRequest;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            //
            'Name'=>'required|max:255|unique:products',
            'Price'=>'required|max:7',
            'Descripton'=>'required|max:255',
            'Discount'=>'required|max:2',

        ];
    }
}
