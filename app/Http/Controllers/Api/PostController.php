<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::with( ['user','tags'] )
            ->latest()
            ->paginate(5);

        return $posts;
    }


    public function show( Post $post ){
        return $post;
    }

}
