<?php

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses(RefreshDatabase::class);

test('user tenancy is applied to list', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create([
        'user_id' => $user->id,
        'title' => 'My Link',
    ]);

    $secondUser = User::factory()->create();
    $secondUserLinks = Link::factory(2)->create([
        'user_id' => $secondUser->id,
        'title' => 'Second User Link',
    ]);

    actingAs($user);

    get(route('links.index'))
        // Assert the user's link is visible
        ->assertSee($link->title)
        // Assert the second user's links are not visible
        ->assertDontSee($secondUserLinks->first()->title)
        ->assertDontSee($secondUserLinks->last()->title);
});

test('user tenancy prevents access to other user data', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create([
        'user_id' => $user->id,
        'title' => 'My Link',
    ]);

    $secondUser = User::factory()->create();
    $secondUserLink = Link::factory()->create([
        'user_id' => $secondUser->id,
        'title' => 'Second User Link',
    ]);

    actingAs($user);

    // Can't edit or update other user's links
    get(route('links.edit', $secondUserLink->id))
        ->assertStatus(404);
    put(route('links.update', $secondUserLink->id), [
        'title' => 'Updated Title',
        'url' => 'https://updated.com',
    ])
        ->assertStatus(404);

    // Can't delete other user's links
    delete(route('links.destroy', $secondUserLink->id))
        ->assertStatus(404);
});
