<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{
    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'url' => ['required', 'string', 'url'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'position' => ['nullable', 'integer'],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
