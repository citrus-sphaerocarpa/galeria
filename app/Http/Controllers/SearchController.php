<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function showSearchResults(Request $request)
    {
        $search_query = $request->input('keywords');

        $keywords= request()->validate([
            'keywords' => 'required|max:200',
        ]);

        return view('search.index', compact('search_query'));
    } 

    public function fetchSearchResults($key, Request $request) 
    {
        if (!empty($key)) {
            // Convert "zen-kaku" space into "han-kaku" one
            $str = mb_convert_kana($key, 's');

            // Split on one or more whitespace and ignore empty (eg. trailing space)
            $arr = preg_split('/\s+/', $str, -1, PREG_SPLIT_NO_EMPTY); 

            // Join tables
            $posts = Post::select('posts.*', 'tags.name')->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
            ->join('tags', 'post_tag.tag_id', '=', 'tags.id');

            if(count($arr) == 1) {
                // Only when user put one keyword into the search box, search the user table
                
                // Search for posts using username
                $user_posts = Post::select('posts.*')->join('users', 'posts.user_id', '=', 'users.id')
                ->where('username', 'LIKE', "%{$arr[0]}%");

                // Search for posts using tags
                $results = $posts->select('posts.*')->where('name', 'LIKE', "%{$arr[0]}%")
                ->union($user_posts);
            } else {
                // Search for posts using tag
                $results = $posts->whereIn('name', $arr);
            }
            
            $results = $results->groupby('posts.id')->latest()->paginate(12);

            return $results;
        }        
    }

    public function showSearchTagResults(Request $request)
    {
        $search_query = Tag::where('name', $request->input('keyword'))->first();

        return view('search.tag', compact('search_query'));
    }

    public function fetchTaggedPosts($key, Request $request) 
    {
        $query = Post::query();

        // Join tables
        $posts = Post::select('posts.*')->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
        ->join('tags', 'post_tag.tag_id', '=', 'tags.id')
        ->where('tag_id', $key);

        $results = $posts->latest()->paginate(12);

        return $results;
    }
}
