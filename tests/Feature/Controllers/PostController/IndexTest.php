<?php

use App\Http\Resources\PostResource;
use App\Models\Post;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\get;

it('should return the correct component', function () {
    // A temporary solution to "Not a valid Inertia response." error
    // Since we dont have any Post available, and
    //  the actual error is "Attempt to read property "id" on null."
    Post::factory()->create();

    get(route('posts.index'))
        ->assertInertia(fn (AssertableInertia $page) => 
            $page->component('Posts/Index', true)
        );
});

it('passes posts to the view', function () {
    $posts = Post::factory(3)->create();
    
    get(route('posts.index'))
        ->assertHasResource('post', PostResource::make($posts->first()))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
});