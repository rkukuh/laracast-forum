<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)
            ->has(Post::factory(rand(2, 10)))
            ->create();

        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@laracast-forum.com',
        ]);
    }
}
