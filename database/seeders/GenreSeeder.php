<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name' => 'Electronic', 'slug' => 'electronic', 'color' => '#06B6D4', 'icon' => '⚡', 'description' => 'Electronic music including house, techno, and EDM.'],
            ['name' => 'Hip Hop', 'slug' => 'hip-hop', 'color' => '#F59E0B', 'icon' => '🎤', 'description' => 'Hip hop, rap, and urban beats.'],
            ['name' => 'Rock', 'slug' => 'rock', 'color' => '#EF4444', 'icon' => '🎸', 'description' => 'Rock, alternative, and indie rock music.'],
            ['name' => 'Jazz', 'slug' => 'jazz', 'color' => '#8B5CF6', 'icon' => '🎷', 'description' => 'Jazz, bebop, and fusion.'],
            ['name' => 'Classical', 'slug' => 'classical', 'color' => '#6366F1', 'icon' => '🎻', 'description' => 'Classical orchestral and chamber music.'],
            ['name' => 'R&B', 'slug' => 'rnb', 'color' => '#EC4899', 'icon' => '🎶', 'description' => 'Rhythm and blues, soul, and contemporary R&B.'],
            ['name' => 'Pop', 'slug' => 'pop', 'color' => '#10B981', 'icon' => '🌟', 'description' => 'Popular music across all demographics.'],
            ['name' => 'Folk', 'slug' => 'folk', 'color' => '#84CC16', 'icon' => '🪕', 'description' => 'Folk, acoustic, and singer-songwriter music.'],
            ['name' => 'Metal', 'slug' => 'metal', 'color' => '#374151', 'icon' => '🤘', 'description' => 'Heavy metal, death metal, and hard rock.'],
            ['name' => 'Reggae', 'slug' => 'reggae', 'color' => '#059669', 'icon' => '🌿', 'description' => 'Reggae, dancehall, and ska music.'],
            ['name' => 'Blues', 'slug' => 'blues', 'color' => '#1D4ED8', 'icon' => '🎹', 'description' => 'Blues, delta blues, and Chicago blues.'],
            ['name' => 'Ambient', 'slug' => 'ambient', 'color' => '#7C3AED', 'icon' => '🌊', 'description' => 'Ambient, chill-out, and atmospheric music.'],
        ];
        foreach ($genres as $genre) {
            Genre::updateOrCreate(['slug' => $genre['slug']], $genre);
        }
    }
}