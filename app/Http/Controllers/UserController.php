<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function search(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user) {
            $user->loadCount(['posts', 'followers', 'followings']);
            $user->load('posts.media');
            return redirect()->route('users.show', ['user' => $user]);
        }
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $this->authorize('update', $user);

        $info = $this->usernameUpdateConditions($user, $request);

        $message = 'Profile updated successfully!';
        if ($info['status'] == 'error') {
            $message = 'Profile updated but username update limit exceeded in last 14 days!';
        }

        if (! empty($request->avatar)) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return redirect()->route('users.show', $user)->with([
            'status' => 'success',
            'message' => $message,
        ]);
    }

    public function usernameUpdateConditions($user, $request)
    {
        $info = [
            'status' => 'error',
        ];

        // Check if username update attempts is less than 2
        if ($user->username_update_attempts < 2) {
            $user->update($request->validated());

            // Check if username was changed
            if ($user->wasChanged('username')) {
                $user->increment('username_update_attempts');
                $user->username_last_updated_at = now();
                $user->save();

                $info = [
                    'status' => 'success',
                ];
            }
        } else {
            // Check if it has been more than 14 days since the last username update
            if (Carbon::parse($user->username_last_updated_at)->addDays(14) < now()) {
                $user->update($request->validated());

                // Check if username was changed
                if ($user->wasChanged('username')) {
                    $user->username_update_attempts = 0;
                    $user->username_last_updated_at = now();
                    $user->save();

                    $info = [
                        'status' => 'success',
                    ];
                }
            } else {
                // Update user's other fields, but not the username
                $user->update($request->safe()->except('username'));
            }
        }

        return $info;
    }
}
