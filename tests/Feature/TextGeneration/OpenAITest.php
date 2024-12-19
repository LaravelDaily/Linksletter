<?php

use App\Enums\TextGenerationProviders;
use App\Models\User;
use App\Services\TextGeneration\TextGenerationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

test('can generate header text', function () {
    $user = User::factory()->create();

    $this->instance(
        TextGenerationService::class,
        Mockery::mock(TextGenerationService::class, function ($mock) {
            $mock->shouldReceive('getHeader')->once()->andReturn('Generated header text');
        })
    );

    actingAs($user);

    $request = postJson(route('text-generation'), [
        'type' => 'header',
        'provider' => TextGenerationProviders::OPENAI->value,
    ]);

    $request->assertStatus(200);

    $request->assertExactJson([
        'text' => 'Generated header text',
    ]);
});

test('can generate footer text', function () {
    $user = User::factory()->create();

    $this->instance(
        TextGenerationService::class,
        Mockery::mock(TextGenerationService::class, function ($mock) {
            $mock->shouldReceive('getFooter')->once()->andReturn('Generated footer text');
        })
    );

    actingAs($user);

    $request = postJson(route('text-generation'), [
        'type' => 'footer',
        'provider' => TextGenerationProviders::OPENAI->value,
    ]);

    $request->assertStatus(200);

    $request->assertExactJson([
        'text' => 'Generated footer text',
    ]);
});
