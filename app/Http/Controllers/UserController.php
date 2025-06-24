<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('media');

        if ($request->has('q')) {
            $query->where('username', 'like', '%' . $request->q . '%')
                ->orWhere('name', 'like', '%' . $request->q . '%');
        }

        return view('users.index', [
            'users' => $query->paginate(User::PAGINATE_COUNT),
            'query' => $request->q,
        ]);
    }

    public function show(User $user)
    {
        auth()->user()->attachFollowStatus($user);
        $user->loadCount(['posts', 'followers', 'followings']);
        $user->load('posts.media');
        return view('users.show', compact('user'));
    }
}
