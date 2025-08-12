<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

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
        $data = $request->validated();
        if( $request->hasFile('image') ){
            $data['image'] = $request->file('image')->store('post_images','public');
        }
        $post = $request->user()->posts()->create( $data );
        // $post = Post::create( $request->validated() );
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
        // Gate::authorize( 'update', $post );
        $data = $request->validated();
        if( $request->hasFile('image') ){
            $data['image'] = $request->file('image')->store('post_images','public');
        }
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
        $post->delete();
        return redirect()
            ->route( 'posts.index' )
            ->with('success','پست حذف شد!');
    }
}
