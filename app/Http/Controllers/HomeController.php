<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

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

    public function submitPost(Request $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->author = $request->input('author');

        if (!$post->save()) {
            return response('Failed to save post', 500);
        }

        return response('OK');
    }
}
