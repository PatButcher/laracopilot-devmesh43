<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Channel;
use App\Models\Genre;

class ChannelSeeder extends Seeder
{
    public function run(): void
    {
        $channels = [
            ['name' => 'Trending Now', 'slug' => 'trending-now', 'type' => 'tracks', 'color' => '#EF4444', 'desc' => 'The hottest tracks right now.', 'sort' => 1],
            ['name' => 'New Releases', 'slug' => 'new-releases', 'type' => 'tracks', 'color' => '#10B981', 'desc' => 'Fresh music just uploaded.', 'sort' => 2],
            ['name' => 'Electronic Realm', 'slug' => 'electronic-realm', 'type' => 'tracks', 'color' => '#06B6D4', 'desc' => 'The best electronic music.', 'sort' => 3, 'genre' => 'electronic'],
            ['name' => 'Featured Albums', 'slug' => 'featured-albums', 'type' => 'albums', 'color' => '#8B5CF6', 'desc' => 'Standout albums from top artists.', 'sort' => 4],
            ['name' => 'Rising Artists', 'slug' => 'rising-artists', 'type' => 'artists', 'color' => '#F59E0B', 'desc' => 'Discover the next big names.', 'sort' => 5],
            ['name' => 'Community Playlists', 'slug' => 'community-playlists', 'type' => 'playlists', 'color' => '#EC4899', 'desc' => 'Curated by the SoundWave community.', 'sort' => 6],
        ];
        foreach ($channels as $ch) {
            $genreId = null;
            if (isset($ch['genre'])) {
                $genre = Genre::where('slug', $ch['genre'])->first();
                $genreId = $genre ? $genre->id : null;
            }
            Channel::updateOrCreate(['slug' => $ch['slug']], [
                'name' => $ch['name'], 'slug' => $ch['slug'],
                'type' => $ch['type'], 'color' => $ch['color'],
                'description' => $ch['desc'], 'sort_order' => $ch['sort'],
                'genre_id' => $genreId, 'is_active' => true,
            ]);
        }
    }
}