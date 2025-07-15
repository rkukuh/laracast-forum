<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $posts = Post::factory(100)
            ->has(Comment::factory(rand(10, 20))->recycle($users))
            ->recycle($users)
            ->create();

        $admin = User::factory()
            ->has(Post::factory(rand(2, 10)))
            ->has(Comment::factory(rand(50, 100))->recycle($posts))
            ->create([
                'name' => 'Super Admin',
                'email' => 'admin@laracast-forum.com',
            ]);
    }
}
