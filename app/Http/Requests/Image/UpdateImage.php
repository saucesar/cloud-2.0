<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateImage extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('images', 'name')->ignore($this->route()->parameters['image'])],
            'description' => ['required', 'min:20'],
            'fromImage' => ['required'],
            'tag' => ['required'],
        ];
    }
}
