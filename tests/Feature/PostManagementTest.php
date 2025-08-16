<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

test('A Guest cannot visit the Create post page', function () {
    $response = $this->get( route('posts.create') );

    $response->assertRedirect( route('login') );
});

test('An Authenticated user can visit the Create post page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs( $user )->get( route('posts.create') );
    
    $response->assertOk();
});

test('An Authenticated user can create a post', function(){
    $user = User::factory()->create();
    $postData = ['title'=>'title 1a','content'=>'content 1'];

    $response = $this->actingAs( $user )
        ->post( route('posts.store'), $postData );
    $response->assertRedirect();

    $this->assertDatabaseHas('posts', [
        'title' => 'title 1a'
    ]);
});
