<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TrackAdminController extends Controller
{
    private function checkAuth() {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($r = $this->checkAuth()) return $r;
        $tracks = Track::with(['artist', 'genre', 'user'])->latest()->paginate(20);
        return view('admin.tracks.index', compact('tracks'));
    }

    public function create()
    {
        if ($r = $this->checkAuth()) return $r;
        $artists = Artist::orderBy('name')->get();
        $albums = Album::orderBy('title')->get();
        $genres = Genre::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('admin.tracks.create', compact('artists', 'albums', 'genres', 'users'));
    }

    public function store(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'artist_id' => 'nullable|exists:artists,id',
            'album_id' => 'nullable|exists:albums,id',
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string',
            'audio_file' => 'required|file|mimes:mp3,wav,ogg,flac,aac|max:51200',
            'cover_image' => 'nullable|image|max:5120',
            'tags' => 'nullable|string',
            'duration' => 'nullable|integer',
        ]);

        $audioFile = $request->file('audio_file');
        $audioFileName = time() . '_' . Str::slug(pathinfo($audioFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $audioFile->getClientOriginalExtension();
        $audioPath = $audioFile->storeAs('tracks/audio', $audioFileName, 'public');

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image');
            $coverPath = $cover->storeAs('tracks/covers', time() . '_cover.' . $cover->getClientOriginalExtension(), 'public');
        }

        $slug = Str::slug($validated['title']);
        $base = $slug;
        $i = 1;
        while (Track::where('slug', $slug)->exists()) $slug = $base . '-' . $i++;

        Track::create(array_merge($validated, [
            'slug' => $slug,
            'audio_path' => $audioPath,
            'cover_image' => $coverPath,
            'is_published' => $request->has('is_published'),
            'duration' => $validated['duration'] ?? 0,
        ]));

        return redirect()->route('admin.tracks.index')->with('success', 'Track created successfully!');
    }

    public function edit($id)
    {
        if ($r = $this->checkAuth()) return $r;
        $track = Track::findOrFail($id);
        $artists = Artist::orderBy('name')->get();
        $albums = Album::orderBy('title')->get();
        $genres = Genre::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('admin.tracks.edit', compact('track', 'artists', 'albums', 'genres', 'users'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;
        $track = Track::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'nullable|exists:artists,id',
            'album_id' => 'nullable|exists:albums,id',
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:5120',
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($track->cover_image) Storage::disk('public')->delete($track->cover_image);
            $cover = $request->file('cover_image');
            $validated['cover_image'] = $cover->storeAs('tracks/covers', time() . '_cover.' . $cover->getClientOriginalExtension(), 'public');
        }

        $validated['is_published'] = $request->has('is_published');
        $track->update($validated);
        return redirect()->route('admin.tracks.index')->with('success', 'Track updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->checkAuth()) return $r;
        $track = Track::findOrFail($id);
        if ($track->audio_path) Storage::disk('public')->delete($track->audio_path);
        if ($track->cover_image) Storage::disk('public')->delete($track->cover_image);
        $track->delete();
        return redirect()->route('admin.tracks.index')->with('success', 'Track deleted.');
    }
}