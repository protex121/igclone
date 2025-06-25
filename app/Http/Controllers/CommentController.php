<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => ['required', 'max:2200'],
        ]);

        $post = Post::where('slug', $request->post_slug)->firstOrFail();

        $comment = $post->commentAsUser(auth()->user(), $request->comment);

        return view('comments.single-comment', compact('comment', 'post'));
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully!',
            'type' => 'success',
        ]);
    }
}
