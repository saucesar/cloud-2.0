<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class StoreImage extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'unique:images'],
            'description' => ['required', 'min:20'],
            'fromImage' => ['required'],
            'tag' => ['required'],
        ];
    }
}
