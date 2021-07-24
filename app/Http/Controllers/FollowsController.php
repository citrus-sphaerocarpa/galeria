<?php

namespace App\Http\Controllers;

use App\Events\UserFollowed;
use App\Models\User;
use App\Notifications\NewFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function store(User $user)
    {
        // $user is the user that is passed from Vue, not authenticated user
        auth()->user()->following()->toggle($user->profile);

        $follow = DB::table('profile_user')->where([
            ['profile_id', $user->id],
            ['user_id', auth()->user()->id],
        ])->exists();

        if($follow) {
            $follow = DB::table('profile_user')->where([
                ['profile_id', $user->id],
                ['user_id', auth()->user()->id],
            ])->first();

            $params = array(
                'id' => $follow->id,
                'profile_id' => $user->id,
                'user_id' => auth()->user()->id,
                'username' => auth()->user()->username,
            );
            // Send a notification when a user gets followed.
            broadcast(new UserFollowed($params))->toOthers();
            $user->notify(new NewFollower($params));
        }

        return back();
    }

    public function index(User $user)
    {
        $followings = auth()->user()->following()->get();
        $followers = auth()->user()->profile->followers()->get();

        return view('follow', compact('user', 'followings', 'followers'));
    }

}
