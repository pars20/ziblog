<?php

namespace App\Http\Controllers;

use Spatie\Image\Image;
use Spatie\Image\Enums\Fit;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with( ['user','tags'] )
            //->orderBy( 'created_at', 'desc' )
            ->latest()
            ->paginate(5);
            //->get();
        return view( 'posts.index', compact('posts') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize( 'create', Post::class );
        $tags = Tag::all();
        return view( 'posts.create', compact('tags') );
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

        $post->tags()->sync( $request->input('tags',[]) );

        return redirect()
            ->route( 'posts.show', $post )
            ->with('success','این پست همین الان منتشر شد!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load( ['user','tags'] );
        return view( 'posts.show', compact('post') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize( 'update', $post );
        $tags = Tag::all();
        $postTagIds = $post->tags->pluck('id')->toArray();
        return view( 'posts.edit', compact('post','tags', 'postTagIds') );
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

        $post->tags()->sync( $request->input('tags',[]) );

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
        if ($post->image  && Storage::disk('public')->exists($post->image) ) {
            Storage::disk('public')->delete( $post->image );
        }
        
        $file = $request->file('image');
        $extension = 'webp'; // $file->getClientOriginalExtension();
        $filename = $post->slug.".$extension";
        $path = "post-images";
        $fullPath = "$path/$filename";
        $counter = 1;
        while( Storage::disk('public')->exists( $fullPath ) ){
            $filename = $post->slug ."-$counter.$extension";
            $fullPath = "$path/$filename";
            $counter++;
        }

        $image = Image::useImageDriver( 'gd' )
            ->loadFile( $file->getRealPath() );
        if ($image->getWidth() > 500 || $image->getHeight() > 500) {
            $image->fit(Fit::Contain, 500, 500);
        }
        $image->save(Storage::disk('public')->path($fullPath));
        //->fit( Fit::Contain, 500, 500 )
        //->save( Storage::disk('public')->path( $fullPath ) );

        return $fullPath;

        // $imagePath = $file->storeAs($path,$filename,'public');
        // $post->image = $imagePath;
        // $post->save();
        // return $imagePath;
        
    }
    
}
