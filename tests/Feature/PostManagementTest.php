<?php

use App\Models\User;
use App\Models\Post;

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

test('User Can Edit their own post',function(){
    $postOwner = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $postOwner->id
    ]);

    $new_title = 'post new title';
    $response = $this->actingAs( $postOwner )
        ->put( route('posts.update', $post),[
            'title' => $new_title, 'content' => 'content eidted',
        ] );

    $response->assertRedirect();

    $this->assertDatabaseHas( 'posts', [
        'id' => $post->id,
        'title' => $new_title
    ]);

});

test('User Can Delete their own post', function(){
    $postOwner = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $postOwner->id
    ]);

    $response = $this->actingAs( $postOwner )
        ->delete( route('posts.destroy', $post) );

    $response->assertRedirect();

    $this->assertDatabaseMissing( 'posts', [
        'id' => $post->id,
    ]);

});


test('User Can Not Delete other users post', function(){
    $postOwner = User::factory()->create();
    $attacker = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $postOwner->id
    ]);

    $response = $this->actingAs( $attacker )
        ->delete( route('posts.destroy', $post) );

    $response->assertStatus( 403 );

    $this->assertDatabaseHas( 'posts', [
        'id' => $post->id,
        'title' => $post->title
    ]);

});

test('User Can Not Edit other users post', function(){
    $postOwner = User::factory()->create();
    $attacker = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $postOwner->id
    ]);

    $response = $this->actingAs( $attacker )
        ->put( route('posts.update',$post),[
            'title' => 'a new hacked title', 'content' => 'hacked content'
        ]);

    $response->assertStatus( 403 );

    $this->assertDatabaseHas( 'posts', [
        'id' => $post->id,
        'title' => $post->title,
    ]);

});



