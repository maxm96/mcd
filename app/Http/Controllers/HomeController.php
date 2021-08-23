<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function getPosts($page = 0, $count = 5)
    {
        $posts = Post::with('comments')
            ->skip($page * $count)
            ->take($count)
            ->orderBy('created_at', 'desc')
            ->get()
            ->all();

        $total = Post::all()->count();

        return [
            'posts' => $posts,
            'total' => $total,
        ];
    }

    public function submitPost(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->author = Auth::check() ? Auth::user()->name : 'Anonymous';

        if (!$post->save()) {
            return response('Failed to save post', 500);
        }

        // Get the id
        $post->refresh()->with('comments');

        return response()->json([
            'post' => $post,
        ]);
    }

    public function submitComment(CommentRequest $request)
    {
        $content = $request->input('content');
        $postId = $request->input('postId');

        Comment::create([
            'author' => Auth::check() ? Auth::user()->name : 'Anonymous',
            'content' => $content,
            'post_id' => $postId,
        ]);

        return response()->json([
            'comments' => Comment::where('post_id', '=', $postId)->get()->all(),
        ]);
    }
}
