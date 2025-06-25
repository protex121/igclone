<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = auth()->user()->followings()->pluck('followable_id');

        $posts = Post::with([
            'media', 'user.media', 'likers.media', 'comments' => function ($query) {
                $query->with('commentator')->latest()->limit(2);
            },
        ])
            ->withCount(['comments', 'likers'])
            ->whereIn('user_id', $users)
            ->latest()
            ->paginate(Post::PAGINATE_COUNT);

        $suggestedUsers = User::whereNotIn('id', $users)
            ->where('id', '<>', auth()->id())
            ->inRandomOrder()
            ->take(10)
            ->get();
        
        $suggestedPosts = [];
        
        return view('posts.index', compact('posts', 'suggestedUsers', 'suggestedPosts'));
    }
}
