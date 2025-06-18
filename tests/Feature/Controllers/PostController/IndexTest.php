<?php

use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\get;

it('should return the correct component', function () {
    get(route('posts.index'))
        ->assertInertia(fn (AssertableInertia $page) => 
            $page->component('Posts/Index', true)
        );
});

it('passes posts to the view', function () {
    get(route('posts.index'))
        ->assertInertia(fn (AssertableInertia $page) => 
            $page->has('posts')
        );
});