<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueRequest;
use App\Jobs\GenerateIssueHtmlJob;
use App\Models\Issue;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function index(): View
    {
        $issues = Issue::query()
            ->where('user_id', auth()->id())
            ->withCount('links')
            ->orderBy('id', 'desc')
            ->paginate(20);

        $availableLinks = Link::query()
            ->where('user_id', auth()->id())
            ->where('issue_id', null)
            ->count();

        return view('issues.index', [
            'issues' => $issues,
            'availableLinks' => $availableLinks,
        ]);
    }

    public function create(): View
    {
        $links = Link::query()
            ->where('user_id', auth()->id())
            ->where('issue_id', null)
            ->get();

        return view('issues.create', [
            'links' => $links,
        ]);
    }

    public function store(StoreIssueRequest $request): RedirectResponse
    {
        $issue = Issue::create($request->validated() + [
            'user_id' => auth()->id(),
        ]);

        Link::query()
            ->where('user_id', auth()->id())
            ->where('issue_id', null)
            ->update(['issue_id' => $issue->id]);

        dispatch(new GenerateIssueHtmlJob($issue->id));

        return redirect()->route('issues.index')
            ->with('message', 'Issue created successfully.');
    }
}
