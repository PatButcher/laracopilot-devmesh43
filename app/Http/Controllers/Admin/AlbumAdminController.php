<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AlbumAdminController extends Controller
{
    private function guard() {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($r = $this->guard()) return $r;
        $albums = Album::with('artist')->withCount('tracks')->latest()->paginate(20);
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        if ($r = $this->guard()) return $r;
        $artists = Artist::orderBy('name')->get();
        return view('admin.albums.create', compact('artists'));
    }

    public function store(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'release_year' => 'nullable|integer|min:1900|max:2099',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:5120',
        ]);
        $slug = Str::slug($validated['title']);
        $base = $slug; $i = 1;
        while (Album::where('slug', $slug)->exists()) $slug = $base . '-' . $i++;
        if ($request->hasFile('cover_image')) {
            $img = $request->file('cover_image');
            $validated['cover_image'] = $img->storeAs('albums', time() . '.' . $img->getClientOriginalExtension(), 'public');
        }
        Album::create(array_merge($validated, ['slug' => $slug]));
        return redirect()->route('admin.albums.index')->with('success', 'Album created!');
    }

    public function edit($id)
    {
        if ($r = $this->guard()) return $r;
        $album = Album::findOrFail($id);
        $artists = Artist::orderBy('name')->get();
        return view('admin.albums.edit', compact('album', 'artists'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->guard()) return $r;
        $album = Album::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'release_year' => 'nullable|integer|min:1900|max:2099',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:5120',
        ]);
        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) Storage::disk('public')->delete($album->cover_image);
            $img = $request->file('cover_image');
            $validated['cover_image'] = $img->storeAs('albums', time() . '.' . $img->getClientOriginalExtension(), 'public');
        }
        $album->update($validated);
        return redirect()->route('admin.albums.index')->with('success', 'Album updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->guard()) return $r;
        $album = Album::findOrFail($id);
        if ($album->cover_image) Storage::disk('public')->delete($album->cover_image);
        $album->delete();
        return redirect()->route('admin.albums.index')->with('success', 'Album deleted.');
    }
}