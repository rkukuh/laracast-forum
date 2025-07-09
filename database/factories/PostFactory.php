<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => str(fake()->sentence)->beforeLast('.')->title(),
            'body' => Collection::times(rand(5, 10), fn () => fake()->realText(rand(200, 500)))->join(PHP_EOL. PHP_EOL),
        ];
    }
}
