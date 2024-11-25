<?php

use App\Models\Issue;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('can create issues', function () {
    $user = User::factory()->create();
    $links = Link::factory()->count(3)->create(['user_id' => $user->id]);

    actingAs($user);

    // Check if the create issue page is accessible
    get(route('issues.create'))
        ->assertStatus(200)
        ->assertSee('Create Issue')
        ->assertSee('Subject')
        ->assertSee('Header Text')
        ->assertSee('Links to be Included')
        ->assertSee($links->pluck('title')->toArray())
        ->assertSee('Footer Text');

    // Create an issue
    post(route('issues.store'), [
        'subject' => 'Test Issue',
        'header_text' => 'This is a test issue',
        'footer_text' => 'This is a test issue footer',
    ])
        ->assertStatus(302)
        ->assertRedirect(route('issues.index'))
        ->assertSessionHas('message', 'Issue created successfully.');

    // Check if the issue is created
    $this->assertDatabaseHas('issues', [
        'subject' => 'Test Issue',
        'header_text' => 'This is a test issue',
        'footer_text' => 'This is a test issue footer',
    ]);

    // Check if the links are attached to the issue
    $issue = Issue::where('subject', 'Test Issue')->first();
    $this->assertEquals($links->pluck('id')->toArray(), $issue->links->pluck('id')->toArray());
});

test('can list issues', function () {
    $user = User::factory()->create();
    $issues = Issue::factory()->count(3)->create(['user_id' => $user->id]);

    actingAs($user);

    // Check if the issues list page is accessible
    get(route('issues.index'))
        ->assertStatus(200)
        ->assertSee('Issues')
        ->assertSee($issues->pluck('subject')->toArray());
});

test('can see pagination on list', function () {
    $user = User::factory()->create();
    $issues = Issue::factory()->count(100)->create(['user_id' => $user->id]);

    actingAs($user);

    // Check if the issues list page is accessible
    get(route('issues.index'))
        ->assertStatus(200)
        ->assertSeeText('Next');
});

test('issue create button visibility toggles based on free links count', function () {
    $user = User::factory()->create();

    actingAs($user);

    // Create an issue without selecting any links
    get(route('issues.index'))
        ->assertStatus(200)
        ->assertDontSee('Add New Issue');

    // Create a link
    $link = Link::factory()->create(['user_id' => $user->id]);

    // Check if the create issue button is visible
    get(route('issues.index'))
        ->assertStatus(200)
        ->assertSee('Add New Issue');
});
