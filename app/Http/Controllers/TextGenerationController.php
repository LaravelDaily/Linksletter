<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAiResponseRequest;
use App\Services\Ai\TextGenerationService;
use Exception;
use Illuminate\Http\JsonResponse;

class TextGenerationController extends Controller
{
    public function __invoke(GetAiResponseRequest $request): JsonResponse
    {
        return response()->json([
            'text' => match ($request->input('type')) {
                'header' => (new TextGenerationService)->getHeader((int) auth()->id(), $request->string('provider')),
                'footer' => (new TextGenerationService)->getFooter((int) auth()->id(), $request->string('provider')),
                default => throw new Exception('Provider not supported'), // Required for phpstan.
            },
        ]);
    }
}
