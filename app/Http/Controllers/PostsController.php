<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
 
    public function index()
    {   
        return view('posts.index');
    }

    public function show(Post $post, User $user)
    {
        $favorites = (auth()->user()) ? auth()->user()->favoriting->contains($post->id) : false;
        $comments = $post->comments;
        $tags = $post->tagging()->get();

        return view('posts.show', compact('post', 'user', 'favorites', 'comments', 'tags'));
    }

    public function create()
    {
        // $tags = Tag::select('name AS text')->get()->toJson();
        // dd($tags);
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'image' => 'required|image',
            'caption' => 'max:1000',
            'tags' => '',
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(800, 800);
        $image->save();

        if(!is_null($request->tags)) {

            $tags_arr = [];
            foreach (json_decode($request->tags) as $tag) {
                array_push($tags_arr, $tag->text);
            };

            $tags = [];
            foreach ($tags_arr as $tag) {
                $tag = Tag::firstOrCreate(['name' => $tag]);
                array_push($tags, $tag);
            };
    
            $tag_ids = [];
            foreach ($tags as $tag) {
                array_push($tag_ids, $tag['id']);
            };
    
            auth()->user()->posts()->create([
                'image' => $imagePath,
                'caption' => $data['caption'],
            ])
            ->tagging()->sync($tag_ids);

        } else {

            auth()->user()->posts()->create([
                'image' => $imagePath,
                'caption' => $data['caption'],
            ]);
              
        }

        return redirect('/profile/' . auth()->user()->username);
    }

    public function edit(Post $post, User $user)
    {
        // $this->authorize('update', $user->post);
        // 認証追加

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // $this->authorize('update', $user->post);
        // 認証追加

        $data = request()->validate([
            'caption' => 'max:1000',
            'tags' => '',
        ]);

        if(!is_null($request->tags)) {
            $tags_arr = [];
            foreach (json_decode($request->tags) as $tag) {
                array_push($tags_arr, $tag->text);
            };

            $tags = [];
            foreach ($tags_arr as $tag) {
                $tag = Tag::firstOrCreate(['name' => $tag]);
                array_push($tags, $tag);
            };
    
            $tag_ids = [];
            foreach ($tags as $tag) {
                array_push($tag_ids, $tag['id']);
            };

            $post->tagging()->sync($tag_ids);
        }

        auth()->user()->posts()->where('id', $post->id)->update([
            'caption' => $data['caption'],
        ]);

        return redirect("/p/{$post->id}");
    }

    public function destroy(Post $post)
    {
        // $this->authorize('update', $user->post);
        // 認証追加

        $comments_data = Comment::where('post_id', $post->id)->delete();
        $post_data = Post::findOrFail($post->id)->delete();

        return redirect('/profile/' . auth()->user()->username);
    }

    public function fetchFollowingPosts() {
        $users = auth()->user()->following()->pluck('profiles.user_id')->toArray();
        array_push($users, auth()->user()->id);

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(12);

        return $posts;
    }

    public function fetchFavoritingPosts() {

        $favoritings = auth()->user()->favoriting()->pluck('posts.id');

        $posts = Post::whereIn('id', $favoritings)->with('user')->paginate(12);

        return $posts;
    }

    public function fetchTags(Request $request) {
        $post_id = $request->p;
        
        if($request->p) {
            // Get tags related to post
            $post = Post::find($post_id);
            
            if(!is_null($post)) {
                // Fetch post's tags data using alias
                $tags = $post->tagging()->select('name AS text')->get();

                if(!is_null($tags)) {
                    return $tags->toJson();
                }
            }
        } else {
            // Get all tags
            $tags = Tag::select('name AS text')->get();

            if(!is_null($tags)) {
                return $tags->toJson();
            }
        }
    }
}
