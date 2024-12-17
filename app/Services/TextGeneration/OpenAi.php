<?php

namespace App\Services\TextGeneration;

use App\Models\Link;
use Exception;
use Illuminate\Support\Facades\Http;

use function Sentry\captureException;

class OpenAi
{
    public function getHeader(int $userId): string
    {
        $prompt = view('text-generation.openai.header', [
            'linkTitles' => Link::query()
                ->where('user_id', $userId)
                ->whereNull('issue_id')
                ->pluck('title'),
        ])->render();

        return $this->callOpenAI($prompt);
    }

    public function getFooter(int $userId): string
    {
        $prompt = view('text-generation.openai.footer', [
            'linkTitles' => Link::query()
                ->where('user_id', $userId)
                ->whereNull('issue_id')
                ->pluck('title'),
        ])->render();

        return $this->callOpenAI($prompt);
    }

    private function callOpenAI(string $prompt): string
    {
        try {
            $aiQuery = Http::withToken(config()->string('services.ai.openai.key'))
                ->asJson()
                ->acceptJson()
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

            return $this->parseResponse((array) $aiQuery->json());
        } catch (Exception $e) {
            captureException($e); // Sends the exception to Sentry

            return 'We were unable to generate the content at this time. Please try again later.';
        }
    }

    /** @phpstan-ignore-next-line  */
    private function parseResponse(array $response): string
    {
        return $response['choices'][0]['message']['content'];
    }
}
