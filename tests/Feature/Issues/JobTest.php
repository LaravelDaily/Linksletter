<?php

use App\Jobs\GenerateIssueHtmlJob;
use App\Models\Issue;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function PHPUnit\Framework\assertStringContainsString;

uses(RefreshDatabase::class);

test('job generates correct html', function () {
    $issue = Issue::factory()
        ->has(Link::factory()->count(2))
        ->create([
            'header_text' => 'Header text',
            'footer_text' => 'Footer text',
        ]);

    (new GenerateIssueHtmlJob($issue->id))->handle();

    $issue = $issue->fresh(['links']);

    assertStringContainsString('Header text', $issue->links_html);
    assertStringContainsString('Footer text', $issue->links_html);
    assertStringContainsString($issue->links[0]->title, $issue->links_html);
    assertStringContainsString($issue->links[1]->title, $issue->links_html);
    assertStringContainsString($issue->links[0]->url, $issue->links_html);
    assertStringContainsString($issue->links[1]->url, $issue->links_html);
});

test('job gets called when issue is created', function () {
    Queue::fake();

    $user = User::factory()->create();

    actingAs($user);

    post(route('issues.store'), [
        'subject' => 'Test subject',
    ])
        ->assertStatus(302)
        ->assertSessionHas('message', 'Issue created successfully.');

    Queue::assertPushed(GenerateIssueHtmlJob::class);
});
