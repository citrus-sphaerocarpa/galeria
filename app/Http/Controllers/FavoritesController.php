<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function store(Post $post)
    {
        return auth()->user()->favoriting()->toggle($post);
    }

    public function index(Post $post, User $user)
    {
        $favorites = (auth()->user()) ? auth()->user()->favoriting->contains($post->id) : false;
        
        return view('favorite');
    }
}
