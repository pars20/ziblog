<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with( 'user' )
            //->orderBy( 'created_at', 'desc' )
            ->latest()
            ->get();
        return view( 'posts.index', compact('posts') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize( 'create', Post::class );
        return view( 'posts.create' );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $post = $request->user()->posts()->create( $request->validated() );
        $postCover = $this->savePostCover( $request, $post );
        if( $postCover ){
            $post->image = $postCover;
            $post->save();
        }

        return redirect()
            ->route( 'posts.show', $post )
            ->with('success','این پست همین الان منتشر شد!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load( 'user' );
        return view( 'posts.show', compact('post') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize( 'update', $post );
        return view( 'posts.edit', compact('post') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        $postCover = $this->savePostCover( $request, $post );
        if( $postCover ) $data['image'] = $postCover;
        $post->update( $data );

        return redirect()->route( 'posts.show', $post )
            ->with( 'success', 'این پست همین الان آپدیت شد!' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize( 'delete', $post );

        if( $post->image ){
            Storage::disk('public')->delete( $post->image );
        }

        $post->delete();

        return redirect()
            ->route( 'posts.index' )
            ->with('success','پست حذف شد!');
    }


    private function savePostCover( $request, $post ) : ? string
    {
        if( !$request->hasFile('image') ) return null;

        // If an old image exists for this post, delete it first.
        if ($post->image) {
            Storage::disk('public')->delete( $post->image );
        }
        
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = $post->slug.".$extension";
        $path = "post-images";
        $counter = 1;
        while( Storage::disk('public')->exists("$path/$filename") ){
            $filename = $post->slug ."-$counter.$extension";
            $counter++;
        }
        $imagePath = $file->storeAs($path,$filename,'public');
        //$post->image = $imagePath;
        //$post->save();
        return $imagePath;
        
    }
    
}
