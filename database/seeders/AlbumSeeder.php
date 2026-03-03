<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\Artist;

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['title' => 'Neon Horizons', 'slug' => 'neon-horizons', 'artist' => 'nova-echo', 'year' => 2023, 'desc' => 'A journey through synthetic landscapes and digital dreams.'],
            ['title' => 'Street Verses', 'slug' => 'street-verses', 'artist' => 'kai-rivers', 'year' => 2023, 'desc' => 'Raw storytelling over hard-hitting beats.'],
            ['title' => 'Starlight Reverie', 'slug' => 'starlight-reverie', 'artist' => 'luna-solis', 'year' => 2022, 'desc' => 'Dreamy indie pop for late night contemplation.'],
            ['title' => 'After Hours', 'slug' => 'after-hours-album', 'artist' => 'the-midnight-grove', 'year' => 2022, 'desc' => 'Jazz fusion explorations recorded live in Paris.'],
            ['title' => 'Thunder Road', 'slug' => 'thunder-road', 'artist' => 'axel-storm', 'year' => 2023, 'desc' => 'High-energy alternative rock from the outback.'],
            ['title' => 'Velvet Soul', 'slug' => 'velvet-soul', 'artist' => 'priya-nair', 'year' => 2023, 'desc' => 'Soulful R&B delivered with passion and grace.'],
            ['title' => 'Machine Rhythm', 'slug' => 'machine-rhythm', 'artist' => 'static-pulse', 'year' => 2022, 'desc' => 'Industrial techno from the future.'],
            ['title' => 'Woodland Tales', 'slug' => 'woodland-tales', 'artist' => 'ella-forrest', 'year' => 2023, 'desc' => 'Acoustic folk stories from the Canadian wilderness.'],
        ];
        foreach ($data as $item) {
            $artist = Artist::where('slug', $item['artist'])->first();
            if ($artist) {
                Album::updateOrCreate(['slug' => $item['slug']], [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'artist_id' => $artist->id,
                    'release_year' => $item['year'],
                    'description' => $item['desc'],
                ]);
            }
        }
    }
}