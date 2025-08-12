<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // This handles everything: user_id, timestamps, and model events!
        Post::factory(10)->create();
        // Post::insert([
        //     ['title'=>'title 1', 'content'=> 'content 1','user_id'=>1],
        //     ['title'=>'title 2', 'content'=> 'content 2','user_id'=>1],
        //     ['title'=>'title 3', 'content'=> 'content 3','user_id'=>1],
        //     ['title'=>'title 4', 'content'=> 'content 4','user_id'=>1],
        //     ['title'=>'title 5', 'content'=> 'content 5','user_id'=>1],
        //     ['title'=>'title 6', 'content'=> 'content 6','user_id'=>1],
        //     ['title'=>'title 7', 'content'=> 'content 7','user_id'=>1],
        //     ['title'=>'title 8', 'content'=> 'content 8','user_id'=>1],
        // ]);
    }
}
