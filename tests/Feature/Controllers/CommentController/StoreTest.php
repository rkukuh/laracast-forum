<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('can store a comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    actingAs($user)->post(route('posts.comments.store', $post), [
        'body' => 'This is test comment',
    ]);

    $this->assertDatabaseHas(Comment::class, [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'body' => 'This is test comment',
    ]);
});

it('redirects to the post show page', function () {
    $post = Post::factory()->create();

    actingAs(User::factory()->create())
        ->post(route('posts.comments.store', $post), [
            'body' => 'This is test comment',
        ])
        ->assertRedirect(route('posts.show', $post));
});

it('requires a valid body', function ($value) {
    $post = Post::factory()->create();

    actingAs(User::factory()->create())
        ->post(route('posts.comments.store', $post), [
            'body' => $value,
        ])
        ->assertInvalid('body');
})->with([
    null,
    1,
    1.5,
    true,
    str_repeat('a', 256),
]);
