<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Track;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('artist')->withCount('tracks')->latest()->paginate(20);
        return view('albums.index', compact('albums'));
    }

    public function show($slug)
    {
        $album = Album::with(['artist', 'tracks.genre'])->where('slug', $slug)->firstOrFail();
        $tracks = $album->tracks()->with(['genre'])->where('is_published', true)->orderBy('track_number')->get();
        return view('albums.show', compact('album', 'tracks'));
    }
}