<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playlist;
use App\Models\Track;
use App\Models\User;

class PlaylistSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) return;

        $playlists = [
            ['name' => 'Late Night Vibes', 'desc' => 'Perfect tracks for late night sessions.', 'public' => true],
            ['name' => 'Morning Energy', 'desc' => 'High energy tracks to start your day right.', 'public' => true],
            ['name' => 'Focus & Flow', 'desc' => 'Ambient and electronic music for deep focus.', 'public' => true],
            ['name' => 'Chill Weekend', 'desc' => 'Relaxed vibes for a perfect weekend.', 'public' => true],
        ];

        $tracks = Track::where('is_published', true)->take(20)->get();

        foreach ($playlists as $data) {
            $playlist = Playlist::create([
                'name' => $data['name'],
                'description' => $data['desc'],
                'user_id' => $user->id,
                'is_public' => $data['public'],
            ]);
            $trackSample = $tracks->random(min(5, $tracks->count()));
            foreach ($trackSample as $i => $track) {
                $playlist->tracks()->attach($track->id, ['sort_order' => $i + 1]);
            }
        }
    }
}