<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function postChat(Request $request)
    {
        $content = $request->input('content');

        $chat = Chat::create([
            'user_id' => Auth::user()->id,
            'content' => $content,
        ]);

        broadcast(new ChatSent($chat));

        return response()->json();
    }
}
