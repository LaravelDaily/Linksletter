<?php

namespace App\Services\Ai;

use App\Enums\AiProviders;
use Exception;

class TextGenerationService
{
    public function getHeader(int $userId, string $provider): string
    {
        return match ($provider) {
            Aiproviders::OPENAI->name => (new OpenAi)->getHeader($userId),
            default => throw new Exception('Provider not supported'),
        };
    }

    public function getFooter(int $userId, string $provider): string
    {
        return match ($provider) {
            AiProviders::OPENAI->name => (new OpenAi)->getFooter($userId),
            default => throw new Exception('Provider not supported'),
        };
    }
}
