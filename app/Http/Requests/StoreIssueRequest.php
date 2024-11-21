<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIssueRequest extends FormRequest
{
    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'subject' => ['required'],
            'header_text' => ['nullable'],
            'footer_text' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
