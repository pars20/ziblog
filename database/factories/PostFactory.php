<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Post;
use App\Models\Tag;

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
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'user_id' => rand(1,3), // Assign all posts to user with ID 1
        ];
    }


    public function configure(){
        return 
        $this->afterCreating(
            function( Post $post ){
                $allTags = Tag::all();
                if ($allTags->isNotEmpty()) {
                    $tags = $allTags->random( rand(1,3) )->pluck('id');
                    $post->tags()->attach( $tags );
                }
            }
        );
    }


}
