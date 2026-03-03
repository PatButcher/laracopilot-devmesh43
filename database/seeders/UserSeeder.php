<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Alex Johnson', 'username' => 'alexj', 'email' => 'alex@example.com', 'bio' => 'Music lover and independent artist.'],
            ['name' => 'Sam Chen', 'username' => 'samchen', 'email' => 'sam@example.com', 'bio' => 'Electronic music producer and DJ.'],
            ['name' => 'Maya Williams', 'username' => 'mayaw', 'email' => 'maya@example.com', 'bio' => 'Singer-songwriter exploring indie folk.'],
            ['name' => 'Jordan Lee', 'username' => 'jordanlee', 'email' => 'jordan@example.com', 'bio' => 'Hip hop enthusiast and beat maker.'],
            ['name' => 'Taylor Brooks', 'username' => 'taylorb', 'email' => 'taylor@example.com', 'bio' => 'Jazz musician and music teacher.'],
        ];
        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], array_merge($user, [
                'password' => Hash::make('password123'),
            ]));
        }
    }
}