<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = Track::with(['artist', 'genre', 'user'])
            ->where('is_published', true)
            ->latest()->paginate(20);
        $genres = Genre::orderBy('name')->get();
        return view('tracks.index', compact('tracks', 'genres'));
    }

    public function discover()
    {
        $trendingTracks = Track::with(['artist', 'genre'])
            ->where('is_published', true)
            ->orderBy('play_count', 'desc')
            ->take(20)->get();
        $newReleases = Track::with(['artist', 'genre'])
            ->where('is_published', true)
            ->latest()->take(20)->get();
        $genres = Genre::withCount('tracks')->orderBy('tracks_count', 'desc')->get();
        return view('tracks.discover', compact('trendingTracks', 'newReleases', 'genres'));
    }

    public function show($slug)
    {
        $track = Track::with(['artist', 'album', 'genre', 'user'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedTracks = Track::with(['artist'])
            ->where('genre_id', $track->genre_id)
            ->where('id', '!=', $track->id)
            ->where('is_published', true)
            ->take(6)->get();

        $isFavourited = Auth::check()
            ? Favourite::where('user_id', Auth::id())->where('track_id', $track->id)->exists()
            : false;

        return view('tracks.show', compact('track', 'relatedTracks', 'isFavourited'));
    }

    public function incrementPlay($id)
    {
        $track = Track::findOrFail($id);
        $track->increment('play_count');
        return response()->json(['play_count' => $track->play_count]);
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please log in to upload tracks.');
        }
        $artists = Artist::orderBy('name')->get();
        $albums = Album::orderBy('title')->get();
        $genres = Genre::orderBy('name')->get();
        return view('tracks.create', compact('artists', 'albums', 'genres'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'nullable|exists:artists,id',
            'album_id' => 'nullable|exists:albums,id',
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string|max:2000',
            'audio_file' => 'required|file|mimes:mp3,wav,ogg,flac,aac|max:51200',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tags' => 'nullable|string|max:500',
            // 'is_published' => 'boolean',
        ]);

        $audioFile = $request->file('audio_file');
        $audioFileName = time() . '_' . Str::slug(pathinfo($audioFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $audioFile->getClientOriginalExtension();
        $audioPath = $audioFile->storeAs('tracks/audio', $audioFileName, 'public');

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image');
            $coverName = time() . '_cover.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('tracks/covers', $coverName, 'public');
        }

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Track::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        Track::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'user_id' => Auth::id(),
            'artist_id' => $validated['artist_id'] ?? null,
            'album_id' => $validated['album_id'] ?? null,
            'genre_id' => $validated['genre_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'audio_path' => $audioPath,
            'cover_image' => $coverPath,
            'tags' => $validated['tags'] ?? null,
            // 'is_published' => $request->has('is_published') ? true : false,
            'is_published' => true,
            'duration' => 0,
        ]);

        return redirect()->route('tracks.mine')->with('success', 'Track uploaded successfully!');
    }

    // TODO: FIX is_published REQUEST.

    public function myTracks()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $tracks = Track::with(['artist', 'genre'])
            ->where('user_id', Auth::id())
            ->latest()->paginate(20);
        return view('tracks.mine', compact('tracks'));
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $track = Track::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $artists = Artist::orderBy('name')->get();
        $albums = Album::orderBy('title')->get();
        $genres = Genre::orderBy('name')->get();
        return view('tracks.edit', compact('track', 'artists', 'albums', 'genres'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $track = Track::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'nullable|exists:artists,id',
            'album_id' => 'nullable|exists:albums,id',
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string|max:2000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tags' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($track->cover_image) {
                Storage::disk('public')->delete($track->cover_image);
            }
            $cover = $request->file('cover_image');
            $coverName = time() . '_cover.' . $cover->getClientOriginalExtension();
            $validated['cover_image'] = $cover->storeAs('tracks/covers', $coverName, 'public');
        }

        $validated['is_published'] = $request->has('is_published');
        $track->update($validated);
        return redirect()->route('tracks.mine')->with('success', 'Track updated successfully!');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $track = Track::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if ($track->audio_path) {
            Storage::disk('public')->delete($track->audio_path);
        }
        if ($track->cover_image) {
            Storage::disk('public')->delete($track->cover_image);
        }
        $track->delete();
        return redirect()->route('tracks.mine')->with('success', 'Track deleted.');
    }
}
