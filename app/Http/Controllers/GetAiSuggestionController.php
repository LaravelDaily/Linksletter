<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAiResponseRequest;
use App\Services\Ai\AiProvider;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class GetAiSuggestionController extends Controller
{
    public function __invoke(GetAiResponseRequest $request): JsonResponse
    {
        return match ($request->input('type')) {
            'header' => response()->json([
                'text' => (new AiProvider)->getHeader((int) auth()->id(), $request->string('provider')),
            ]),
            'footer' => response()->json([
                'text' => (new AiProvider)->getFooter((int) auth()->id(), $request->string('provider')),
            ]),
            default => throw new InvalidArgumentException('Invalid type'),
        };
    }
}
