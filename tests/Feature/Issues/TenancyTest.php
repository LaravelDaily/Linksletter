<?php

use App\Models\Issue;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('users cant see others issues', function () {
    $user = User::factory()->create();
    $issue = Issue::factory()->create(['subject' => 'My Issue', 'user_id' => $user->id]);

    $anotherUser = User::factory()->create();
    $otherUsersIssues = Issue::factory()->count(3)->create([
        'user_id' => $anotherUser->id,
        'subject' => 'Another Issue',
    ]);

    actingAs($user);

    get(route('issues.index'))
        ->assertStatus(200)
        ->assertSeeText($issue->subject)
        ->assertDontSeeText($otherUsersIssues->pluck('subject')->toArray());
});

test('users cant see others links when creating an issue', function () {
    $user = User::factory()->create();
    $userLinks = Link::factory()->create([
        'user_id' => $user->id,
        'title' => 'My Link',
    ]);

    $anotherUser = User::factory()->create();
    $anotherUserLinks = Link::factory()->count(3)->create([
        'user_id' => $anotherUser->id,
        'title' => 'Another Link',
    ]);

    actingAs($user);

    get(route('issues.create'))
        ->assertStatus(200)
        ->assertSeeText($userLinks->title)
        ->assertDontSeeText($anotherUserLinks->pluck('title')->toArray());
});
