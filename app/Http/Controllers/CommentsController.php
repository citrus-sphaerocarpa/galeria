<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function create(Post $post)
    {
        $comment = '';

        return view('posts.comments.create', compact('post', 'comment'));
    }

    public function store(Request $request, $post)
    {
        $data = request()->validate([
            'comment' => ['required', 'max:2000'],
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $input['post_id'] = $post;

        Comment::create($input);

        return redirect('/p/' . $post);
    }

    public function edit($post, $comment) {
        // $this->authorize('update', $user->post);
        // 認証追加
        $comment = Comment::where('id', $comment)->first();

        return view('posts.comments.edit', compact('post', 'comment'));
    }

    public function update($post, $comment)
    {
        // $this->authorize('update', $user->post);
        // 認証追加

        $data = request()->validate([
            'comment' => ['required', 'max:2000'],
        ]);

        Comment::where('id', $comment)->update($data);

        return redirect("/p/{$post}");
    }

    public function createReply(Post $post, Comment $comment)
    {
        return view('posts.comments.create', compact('post', 'comment'));
    }

    public function storeReply(Request $request, $post, $comment)
    {
        $data = request()->validate([
            'comment' => ['required', 'max:2000'],
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $input['post_id'] = $post;
        $input['parent_id'] = $comment;

        Comment::create($input);

        return redirect('/p/' . $post);
    }

    public function destroy(Request $request, $post, $comment)
    {
        // $this->authorize('update', $comment);
        // ここで認証かける

        // Comment::where('id', $comment)->update([
        //     'comment' => 'This comment has been deleted.'
        // ]);

        Comment::where('id', $comment)->delete();

        return redirect('/p/' . $post);
    }

}
