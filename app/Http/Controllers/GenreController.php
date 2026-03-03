<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Track;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('tracks')->orderBy('name')->get();
        return view('genres.index', compact('genres'));
    }

    public function show($slug)
    {
        $genre = Genre::where('slug', $slug)->firstOrFail();
        $tracks = Track::with(['artist', 'album'])
            ->where('genre_id', $genre->id)
            ->where('is_published', true)
            ->latest()->paginate(20);
        return view('genres.show', compact('genre', 'tracks'));
    }
}