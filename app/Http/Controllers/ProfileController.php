<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        if (!Auth::check()) return redirect()->route('login');
        $user = Auth::user();
        $tracks = Track::where('user_id', $user->id)->latest()->take(10)->get();
        $playlists = Playlist::where('user_id', $user->id)->latest()->take(10)->get();
        return view('profile.show', compact('user', 'tracks', 'playlists'));
    }

    public function edit()
    {
        if (!Auth::check()) return redirect()->route('login');
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'current_password' => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        unset($validated['current_password']);

        $user->update($validated);
        return redirect()->route('profile.show')->with('success', 'Profile updated!');
    }
}