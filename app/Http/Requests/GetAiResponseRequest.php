<?php

namespace App\Http\Requests;

use App\Enums\AiProviders;
use Illuminate\Foundation\Http\FormRequest;

class GetAiResponseRequest extends FormRequest
{
    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'type' => ['string', 'in:header,footer'],
            'provider' => ['required', 'string', 'in:'.collect(AiProviders::cases())->pluck('name')->implode(',')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
