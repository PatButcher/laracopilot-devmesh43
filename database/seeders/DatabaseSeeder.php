<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            GenreSeeder::class,
            ArtistSeeder::class,
            AlbumSeeder::class,
            TrackSeeder::class,
            UserSeeder::class,
            PlaylistSeeder::class,
            ChannelSeeder::class,
            MenuItemSeeder::class,
        ]);
    }
}