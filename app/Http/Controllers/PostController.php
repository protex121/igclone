<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index() {}

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $post = Post::create([
            'user_id' => auth()->id(),
            'slug' => Str::random(12),
            'caption' => $request->caption,
        ]);

        if ($request->hasFile('image')) {
            $post->addMultipleMediaFromRequest(['image'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('posts');
            });
        }

        return redirect()->route('users.show', auth()->user())->with([
            'status' => 'success',
            'message' => 'Post uploaded successfully!',
        ]);
    }

    public function show(Post $post)
    {
        $post->load([
            'comments' => function ($query) {
                $query->with('commentator', 'commentator')->latest();
            },
        ])->loadCount('comments', 'likers');

        return view('posts.show', compact('post'));
    }
}
