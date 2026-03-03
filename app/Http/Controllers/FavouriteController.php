<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function index()
    {
        if (!Auth::check()) return redirect()->route('login');
        $favourites = Favourite::with(['track.artist', 'track.genre'])
            ->where('user_id', Auth::id())
            ->latest()->paginate(20);
        return view('favourites.index', compact('favourites'));
    }

    public function toggle(Request $request, $trackId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Login required'], 401);
        }
        $track = Track::findOrFail($trackId);
        $existing = Favourite::where('user_id', Auth::id())->where('track_id', $trackId)->first();
        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Favourite::create(['user_id' => Auth::id(), 'track_id' => $trackId]);
            return response()->json(['status' => 'added']);
        }
    }
}