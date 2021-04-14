<?php

namespace App\Http\Requests\Container;

use Illuminate\Foundation\Http\FormRequest;

class StoreContainer extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nickname' => 'required|string|unique:containers',
            'image_id' => 'required|numeric|exists:images,id',
        ];
    }
}
