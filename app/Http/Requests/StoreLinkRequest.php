<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{
    public function rules()
    {
        return [
            'url' => ['required', 'string', 'url'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'position' => ['nullable', 'integer'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
