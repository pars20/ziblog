<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TagController extends Controller
{

    public function index(){
        $tags = Tag::latest()->paginate(5);
        return view( 'tags.index', compact('tags') );
    }

    public function show( Tag $tag ){
        // $tag->load( 'posts' );
        $posts = $tag
            ->posts()
            ->latest()
            ->with('user')    
            ->paginate(5);
        return view('tags.show', compact('tag','posts') );
    }

    public function create(){
        return view( 'tags.create' );
    }


    public function store( Request $request ){

        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);

        $tag = Tag::create( $validated );

        Cache::forget( 'tags_all ');

        return redirect()
            ->route('tags.index' )
            ->with('success','این تگ الان ساخته شد.');

    }


}
