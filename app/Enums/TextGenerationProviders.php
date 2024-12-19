<?php

namespace App\Enums;

enum TextGenerationProviders: string
{
    case OPENAI = 'openai';
    case CLAUDE = 'claude'; // TODO
    case GEMINI = 'gemini'; // TODO
}
