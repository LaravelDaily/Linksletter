<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LinkController extends Controller
{
    public function index(): View
    {
        $links = Link::query()
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->paginate(1);

        return view('links.index', [
            'links' => $links,
        ]);
    }

    public function create(): View
    {
        $users = User::all();

        return view('links.create', [
            'users' => $users,
        ]);
    }

    public function store(StoreLinkRequest $request): RedirectResponse
    {
        $link = Link::create(
            $request->validated() + [
                'user_id' => auth()->id(),
            ]
        );

        if (! $link->position) {
            /** @var int $maxPosition */
            $maxPosition = Link::max('position');

            $link->position = $maxPosition + 1;
            $link->save();
        }

        return redirect()->route('links.index')
            ->with('message', 'Link created successfully.');
    }

    public function edit(Link $link): View
    {
        abort_unless($link->user_id === auth()->id(), 404);

        $users = User::all();

        return view('links.edit', [
            'link' => $link,
            'users' => $users,
        ]);
    }

    public function update(UpdateLinkRequest $request, Link $link): RedirectResponse
    {
        abort_unless($link->user_id === auth()->id(), 404);

        $link->update($request->validated());

        return redirect()->route('links.index')
            ->with('message', 'Link updated successfully.');
    }

    public function destroy(Link $link): RedirectResponse
    {
        abort_unless($link->user_id === auth()->id(), 404);

        $link->delete();

        return redirect()->route('links.index')
            ->with('message', 'Link deleted successfully.');
    }
}
