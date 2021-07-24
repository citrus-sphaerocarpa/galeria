<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index($username)
    {
        $user = User::where('username', $username)->first();

        if(!is_null($user)) {
            // Check if user is followed or not
            $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
            
            $notifications = auth()->user()->unreadNotifications()->where([
                ['type', 'App\\Notifications\\NewFollower'],
                ['sender_id', $user->id],
                ['notifiable_id', auth()->user()->id],
                ])
                ->get();

            if(!is_null($notifications->toArray())) {
                foreach ($notifications as $notification) {
                    $notification->markAsRead();
                }
            }
            return view('profiles.index', compact('user', 'follows'));
        }

    }

    public function edit($username)
    {
        $user = User::where('username', $username)->first();

        if(!is_null($user)) {
            $this->authorize('update', $user->profile);

            return view('profiles.edit', compact('user'));
        }
    }

    public function update($username)
    {
        $user = User::where('username', $username)->first();

        if(!is_null($user)) {   
            $this->authorize('update', $user->profile);

            $profileData = request()->validate([
                'display_name' => ['max:25'],
                'biography' => ['max:200'],
                'image' => '',
            ]);
            
            if(request('image')) {
                $imagePath = request('image')->store('profile', 'public');

                $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
                $image->save();

                $imageArray = ['image' => $imagePath];
            }
            
            auth()->user()->profile()->update(array_merge(
                $profileData,
                $imageArray ?? []
            ));

            return redirect("/profile/{$username}");
        }
    }

    public function fetchPosts($username)
    {
        $user = User::where('username', $username)->first();
        
        $posts = $user->posts()->latest()->paginate(12);

        return $posts;
    }
}
