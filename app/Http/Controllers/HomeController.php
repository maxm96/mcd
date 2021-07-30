<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function getPosts()
    {
        return Post::all();
    }

    public function submitPost(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->author = Auth::user() ? Auth::user()->username : 'Anonymous';

        if (!$post->save()) {
            return response('Failed to save post', 500);
        }

        return response()->json([
            'post' => [
                'title' => $post->title,
                'content' => $post->content,
                'author' => $post->author,
            ]
        ]);
    }
}
