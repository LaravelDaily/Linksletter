<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('validates issue subject', function () {
    $user = User::factory()->create();

    actingAs($user);

    post(route('issues.store'), [
        'subject' => '',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['subject' => 'The subject field is required.']);
});
