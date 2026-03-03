<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;
use App\Models\User;

class TrackSeeder extends Seeder
{
    public function run(): void
    {
        $tracks = [
            ['title' => 'Digital Sunrise', 'artist' => 'nova-echo', 'genre' => 'electronic', 'album' => 'neon-horizons', 'duration' => 245, 'plays' => 15420, 'tags' => 'electronic, ambient, synth'],
            ['title' => 'Neon Pulse', 'artist' => 'nova-echo', 'genre' => 'electronic', 'album' => 'neon-horizons', 'duration' => 312, 'plays' => 9830, 'tags' => 'electronic, dance, techno'],
            ['title' => 'Ghost Protocol', 'artist' => 'nova-echo', 'genre' => 'electronic', 'album' => 'neon-horizons', 'duration' => 198, 'plays' => 7200, 'tags' => 'electronic, dark, bass'],
            ['title' => 'City Chronicles', 'artist' => 'kai-rivers', 'genre' => 'hip-hop', 'album' => 'street-verses', 'duration' => 223, 'plays' => 28900, 'tags' => 'hip-hop, rap, storytelling'],
            ['title' => 'Midnight Grind', 'artist' => 'kai-rivers', 'genre' => 'hip-hop', 'album' => 'street-verses', 'duration' => 198, 'plays' => 19500, 'tags' => 'hip-hop, trap, beats'],
            ['title' => 'Rise Up', 'artist' => 'kai-rivers', 'genre' => 'hip-hop', 'album' => 'street-verses', 'duration' => 267, 'plays' => 31200, 'tags' => 'hip-hop, motivational, rap'],
            ['title' => 'Moonchild', 'artist' => 'luna-solis', 'genre' => 'pop', 'album' => 'starlight-reverie', 'duration' => 234, 'plays' => 45600, 'tags' => 'indie pop, dreamy, vocals'],
            ['title' => 'Starfall', 'artist' => 'luna-solis', 'genre' => 'pop', 'album' => 'starlight-reverie', 'duration' => 218, 'plays' => 38200, 'tags' => 'pop, indie, ethereal'],
            ['title' => 'Velvet Sky', 'artist' => 'luna-solis', 'genre' => 'pop', 'album' => 'starlight-reverie', 'duration' => 251, 'plays' => 29800, 'tags' => 'pop, chill, vocals'],
            ['title' => 'Blue Monk Revisited', 'artist' => 'the-midnight-grove', 'genre' => 'jazz', 'album' => 'after-hours-album', 'duration' => 389, 'plays' => 8700, 'tags' => 'jazz, fusion, live'],
            ['title' => 'After Midnight', 'artist' => 'the-midnight-grove', 'genre' => 'jazz', 'album' => 'after-hours-album', 'duration' => 412, 'plays' => 6500, 'tags' => 'jazz, bebop, fusion'],
            ['title' => 'Thunderstruck Highway', 'artist' => 'axel-storm', 'genre' => 'rock', 'album' => 'thunder-road', 'duration' => 276, 'plays' => 22100, 'tags' => 'rock, guitar, alternative'],
            ['title' => 'Broken Silence', 'artist' => 'axel-storm', 'genre' => 'rock', 'album' => 'thunder-road', 'duration' => 305, 'plays' => 18400, 'tags' => 'rock, heavy, riff'],
            ['title' => 'Sweet Surrender', 'artist' => 'priya-nair', 'genre' => 'rnb', 'album' => 'velvet-soul', 'duration' => 228, 'plays' => 33600, 'tags' => 'r&b, soul, vocals'],
            ['title' => 'Midnight Love', 'artist' => 'priya-nair', 'genre' => 'rnb', 'album' => 'velvet-soul', 'duration' => 245, 'plays' => 27900, 'tags' => 'r&b, smooth, love'],
            ['title' => 'Cyber Grid', 'artist' => 'static-pulse', 'genre' => 'electronic', 'album' => 'machine-rhythm', 'duration' => 356, 'plays' => 12300, 'tags' => 'techno, industrial, bass'],
            ['title' => 'Iron Beats', 'artist' => 'static-pulse', 'genre' => 'electronic', 'album' => 'machine-rhythm', 'duration' => 423, 'plays' => 9800, 'tags' => 'techno, hard, electronic'],
            ['title' => 'Birchwood Morning', 'artist' => 'ella-forrest', 'genre' => 'folk', 'album' => 'woodland-tales', 'duration' => 196, 'plays' => 14200, 'tags' => 'folk, acoustic, guitar'],
            ['title' => 'The River Song', 'artist' => 'ella-forrest', 'genre' => 'folk', 'album' => 'woodland-tales', 'duration' => 234, 'plays' => 11700, 'tags' => 'folk, storytelling, nature'],
            ['title' => 'Echoes of Stone', 'artist' => 'ironwave', 'genre' => 'metal', 'album' => null, 'duration' => 367, 'plays' => 19800, 'tags' => 'metal, progressive, heavy'],
            ['title' => 'Cosmos Drift', 'artist' => 'dusk-garden', 'genre' => 'ambient', 'album' => null, 'duration' => 584, 'plays' => 8900, 'tags' => 'ambient, meditation, drone'],
            ['title' => 'Sunrise Riddim', 'artist' => 'rio-vibes', 'genre' => 'reggae', 'album' => null, 'duration' => 243, 'plays' => 16400, 'tags' => 'reggae, rhythm, positive'],
            ['title' => 'String Quartet No. 7', 'artist' => 'cello-collective', 'genre' => 'classical', 'album' => null, 'duration' => 891, 'plays' => 5600, 'tags' => 'classical, strings, quartet'],
        ];

        foreach ($tracks as $index => $data) {
            $artist = Artist::where('slug', $data['artist'])->first();
            $genre = Genre::where('slug', $data['genre'])->first();
            $album = $data['album'] ? Album::where('slug', $data['album'])->first() : null;
            if (!$artist || !$genre) continue;
            $slug = \Illuminate\Support\Str::slug($data['title']);
            Track::updateOrCreate(['slug' => $slug], [
                'title' => $data['title'],
                'slug' => $slug,
                'artist_id' => $artist->id,
                'genre_id' => $genre->id,
                'album_id' => $album ? $album->id : null,
                'duration' => $data['duration'],
                'play_count' => $data['plays'],
                'tags' => $data['tags'],
                'is_published' => true,
                'audio_path' => 'tracks/audio/sample.mp3',
                'description' => 'A captivating track by ' . $artist->name . ' from the ' . ($genre->name ?? '') . ' genre.',
            ]);
        }
    }
}