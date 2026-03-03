<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelAdminController extends Controller
{
    private function guard() {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($r = $this->guard()) return $r;
        $channels = Channel::withCount('tracks')->orderBy('sort_order')->paginate(20);
        return view('admin.channels.index', compact('channels'));
    }

    public function create()
    {
        if ($r = $this->guard()) return $r;
        $genres = Genre::orderBy('name')->get();
        return view('admin.channels.create', compact('genres'));
    }

    public function store(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:tracks,albums,artists,playlists,genres,mixed',
            'genre_id' => 'nullable|exists:genres,id',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        $slug = Str::slug($validated['name']);
        $base = $slug; $i = 1;
        while (Channel::where('slug', $slug)->exists()) $slug = $base . '-' . $i++;
        Channel::create(array_merge($validated, [
            'slug' => $slug,
            'is_active' => $request->has('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]));
        return redirect()->route('admin.channels.index')->with('success', 'Channel created!');
    }

    public function edit($id)
    {
        if ($r = $this->guard()) return $r;
        $channel = Channel::findOrFail($id);
        $genres = Genre::orderBy('name')->get();
        return view('admin.channels.edit', compact('channel', 'genres'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->guard()) return $r;
        $channel = Channel::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:tracks,albums,artists,playlists,genres,mixed',
            'genre_id' => 'nullable|exists:genres,id',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
        ]);
        $validated['is_active'] = $request->has('is_active');
        $channel->update($validated);
        return redirect()->route('admin.channels.index')->with('success', 'Channel updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->guard()) return $r;
        Channel::findOrFail($id)->delete();
        return redirect()->route('admin.channels.index')->with('success', 'Channel deleted.');
    }
}