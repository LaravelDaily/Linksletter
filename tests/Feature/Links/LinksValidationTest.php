<?php

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

uses(RefreshDatabase::class);

test('validates link url', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    actingAs($user);

    // Check for URL validation
    post(route('links.store'), [
        'url' => 'invalid-url',
        'title' => 'Link Title',
        'description' => 'Link Description',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['url' => 'The url field must be a valid URL.']);

    put(route('links.update', $link->id), [
        'url' => 'invalid-url',
        'title' => 'Link Title',
        'description' => 'Link Description',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['url' => 'The url field must be a valid URL.']);

    // Check for URL required validation
    post(route('links.store'), [
        'title' => 'Link Title',
        'description' => 'Link Description',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['url' => 'The url field is required.']);

    put(route('links.update', $link->id), [
        'title' => 'Link Title',
        'description' => 'Link Description',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['url' => 'The url field is required.']);

    // Check for URL string validation
    post(route('links.store'), [
        'url' => 123,
        'title' => 'Link Title',
        'description' => 'Link Description',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['url' => 'The url field must be a string.']);

    put(route('links.update', $link->id), [
        'url' => 123,
        'title' => 'Link Title',
        'description' => 'Link Description',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['url' => 'The url field must be a string.']);
});

test('validates link title', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    actingAs($user);

    // Check for title validation
    post(route('links.store'), [
        'url' => 'https://example.com',
        'title' => '',
        'description' => 'Link Description',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['title' => 'The title field is required.']);

    put(route('links.update', $link->id), [
        'url' => 'https://example.com',
        'title' => '',
        'description' => 'Link Description',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['title' => 'The title field is required.']);

    // Check for title string validation
    post(route('links.store'), [
        'url' => 'https://example.com',
        'title' => 123,
        'description' => 'Link Description',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['title' => 'The title field must be a string.']);

    put(route('links.update', $link->id), [
        'url' => 'https://example.com',
        'title' => 123,
        'description' => 'Link Description',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['title' => 'The title field must be a string.']);
});

test('validates link description', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    actingAs($user);

    // Check for description string validation
    post(route('links.store'), [
        'url' => 'https://example.com',
        'title' => 'Link Title',
        'description' => 123,
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['description' => 'The description field must be a string.']);

    put(route('links.update', $link->id), [
        'url' => 'https://example.com',
        'title' => 'Link Title',
        'description' => 123,
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['description' => 'The description field must be a string.']);

    // Check for description nullable validation
    post(route('links.store'), [
        'url' => 'https://example.com',
        'title' => 'Link Title',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasNoErrors();

    put(route('links.update', $link->id), [
        'url' => 'https://example.com',
        'title' => 'Link Title',
        'position' => 1,
    ])
        ->assertStatus(302)
        ->assertSessionHasNoErrors();
});

test('validates link position', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    actingAs($user);

    // Check for position integer validation
    post(route('links.store'), [
        'url' => 'https://example.com',
        'title' => 'Link Title',
        'description' => 'Link Description',
        'position' => 'invalid',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['position' => 'The position field must be an integer.']);

    put(route('links.update', $link->id), [
        'url' => 'https://example.com',
        'title' => 'Link Title',
        'description' => 'Link Description',
        'position' => 'invalid',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['position' => 'The position field must be an integer.']);

    // Check for position nullable validation
    post(route('links.store'), [
        'url' => 'https://example.com',
        'title' => 'Link Title',
        'description' => 'Link Description',
    ])
        ->assertStatus(302)
        ->assertSessionHasNoErrors();

    put(route('links.update', $link->id), [
        'url' => 'https://example.com',
        'title' => 'Link Title',
        'description' => 'Link Description',
    ])
        ->assertStatus(302)
        ->assertSessionHasNoErrors();
});
