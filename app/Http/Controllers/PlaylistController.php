<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) return redirect()->route('login');
        $playlists = Playlist::with('tracks')
            ->where('user_id', Auth::id())
            ->withCount('tracks')
            ->latest()->get();
        return view('playlists.index', compact('playlists'));
    }

    public function create()
    {
        if (!Auth::check()) return redirect()->route('login');
        return view('playlists.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_public' => 'boolean',
        ]);
        $validated['user_id'] = Auth::id();
        $validated['is_public'] = $request->has('is_public');
        Playlist::create($validated);
        return redirect()->route('playlists.index')->with('success', 'Playlist created!');
    }

    public function show($id)
    {
        $playlist = Playlist::with(['tracks.artist', 'tracks.genre', 'user'])->findOrFail($id);
        if (!$playlist->is_public && (!Auth::check() || Auth::id() !== $playlist->user_id)) {
            abort(403);
        }
        return view('playlists.show', compact('playlist'));
    }

    public function edit($id)
    {
        if (!Auth::check()) return redirect()->route('login');
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $tracks = Track::with('artist')->where('is_published', true)->orderBy('title')->get();
        return view('playlists.edit', compact('playlist', 'tracks'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) return redirect()->route('login');
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
        $validated['is_public'] = $request->has('is_public');
        $playlist->update($validated);
        return redirect()->route('playlists.index')->with('success', 'Playlist updated!');
    }

    public function destroy($id)
    {
        if (!Auth::check()) return redirect()->route('login');
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $playlist->delete();
        return redirect()->route('playlists.index')->with('success', 'Playlist deleted.');
    }

    public function addTrack(Request $request, $id)
    {
        if (!Auth::check()) return redirect()->route('login');
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $request->validate(['track_id' => 'required|exists:tracks,id']);
        if (!$playlist->tracks()->where('track_id', $request->track_id)->exists()) {
            $playlist->tracks()->attach($request->track_id, ['sort_order' => $playlist->tracks()->count() + 1]);
        }
        return back()->with('success', 'Track added to playlist!');
    }

    public function removeTrack($id, $trackId)
    {
        if (!Auth::check()) return redirect()->route('login');
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $playlist->tracks()->detach($trackId);
        return back()->with('success', 'Track removed from playlist.');
    }
}