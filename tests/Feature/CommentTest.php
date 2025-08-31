<?php

use App\Models\Post;
use App\Models\User;

test('A logged-in user can send comment on a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs( $user )
        ->post( route('posts.comments.store', $post),[
            'body' => 'comment test 1'
        ] );

    $response->assertRedirect();
    $this->assertDatabaseHas('comments',[
        'user_id' => $user->id,
        'body' => 'comment test 1',
        'commentable_id' => $post->id,
        'commentable_type' => Post::class
    ]);
});
