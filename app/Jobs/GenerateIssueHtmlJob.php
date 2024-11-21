<?php

namespace App\Jobs;

use App\Models\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateIssueHtmlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Issue $issue;

    public function __construct(public int $issueId)
    {
        $this->issue = Issue::with('links')->findOrFail($this->issueId);
    }

    public function handle(): void
    {
        $html = view('issues.components.issueHtml', [
            'issue' => $this->issue,
        ]);

        $this->issue->links_html = $html->render();
        $this->issue->save();
    }
}
