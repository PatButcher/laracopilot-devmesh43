<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $tracks = collect();
        $artists = collect();
        $albums = collect();
        $genres = collect();

        if ($query) {
            $tracks = Track::with(['artist', 'genre'])
                ->where('is_published', true)
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('tags', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })->take(10)->get();

            $artists = Artist::where('name', 'like', "%{$query}%")->take(5)->get();
            $albums = Album::with('artist')->where('title', 'like', "%{$query}%")->take(5)->get();
            $genres = Genre::where('name', 'like', "%{$query}%")->take(5)->get();
        }

        return view('search.index', compact('query', 'tracks', 'artists', 'albums', 'genres'));
    }
}