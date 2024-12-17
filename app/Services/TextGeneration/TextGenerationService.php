<?php

namespace App\Services\TextGeneration;

use App\Enums\TextGenerationProviders;
use Exception;

class TextGenerationService
{
    public function getHeader(int $userId, string $provider): string
    {
        return match ($provider) {
            TextGenerationProviders::OPENAI->name => (new OpenAi)->getHeader($userId),
            default => throw new Exception('Provider not supported'),
        };
    }

    public function getFooter(int $userId, string $provider): string
    {
        return match ($provider) {
            TextGenerationProviders::OPENAI->name => (new OpenAi)->getFooter($userId),
            default => throw new Exception('Provider not supported'),
        };
    }
}
