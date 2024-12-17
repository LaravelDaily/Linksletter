<?php

namespace App\Http\Requests;

use App\Enums\TextGenerationProviders;
use Illuminate\Foundation\Http\FormRequest;

class TextGenerationRequest extends FormRequest
{
    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'type' => ['string', 'in:header,footer'],
            'provider' => ['required', 'string', 'in:'.collect(TextGenerationProviders::cases())->pluck('name')->implode(',')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
