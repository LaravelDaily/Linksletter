<?php

namespace App\Http\Controllers;

use App\Http\Requests\TextGenerationRequest;
use App\Services\TextGeneration\TextGenerationService;
use Exception;
use Illuminate\Http\JsonResponse;

class TextGenerationController extends Controller
{
    public function __invoke(TextGenerationRequest $request, TextGenerationService $textGenerationService): JsonResponse
    {
        return response()->json([
            'text' => match ($request->input('type')) {
                'header' => $textGenerationService->getHeader((int) auth()->id(), $request->string('provider')),
                'footer' => $textGenerationService->getFooter((int) auth()->id(), $request->string('provider')),
                default => throw new Exception('Provider not supported'), // Required for phpstan.
            },
        ]);
    }
}
