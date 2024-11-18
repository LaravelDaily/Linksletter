<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;
use App\Models\User;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::query()
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->paginate(50);

        return view('links.index', [
            'links' => $links,
        ]);
    }

    public function create()
    {
        $users = User::all();

        return view('links.create', [
            'users' => $users,
        ]);
    }

    public function store(StoreLinkRequest $request)
    {
        $link = Link::create(
            $request->validated() + [
                'user_id' => auth()->id(),
            ]
        );

        if (!$link->position) {
            $link->position = Link::max('position') + 1;
            $link->save();
        }

        return redirect()->route('links.index')
            ->with('message', 'Link created successfully.');
    }

    public function edit(Link $link)
    {
        abort_unless($link->user_id === auth()->id(), 404);

        $users = User::all();

        return view('links.edit', [
            'link' => $link,
            'users' => $users,
        ]);
    }

    public function update(UpdateLinkRequest $request, Link $link)
    {
        abort_unless($link->user_id === auth()->id(), 404);

        $link->update($request->validated());

        return redirect()->route('links.index')
            ->with('message', 'Link updated successfully.');
    }

    public function destroy(Link $link)
    {
        abort_unless($link->user_id === auth()->id(), 404);

        $link->delete();

        return redirect()->route('links.index')
            ->with('message', 'Link deleted successfully.');
    }
}
