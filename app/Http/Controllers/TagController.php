<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show( Tag $tag ){
        // $tag->load( 'posts' );
        $posts = $tag
            ->posts()
            ->latest()
            ->with('user')    
            ->paginate(5);
        return view('tags.show', compact('tag','posts') );
    }
}
