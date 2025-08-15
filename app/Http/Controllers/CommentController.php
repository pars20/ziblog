<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class CommentController extends Controller
{
    public function store( Request $request, Post $post ){
        $request->validate([
            'body' => 'required|string|min:5|max:500',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return back()->with('success','کامنت جدید با موفقیت ثبت شد.');
    }
}
