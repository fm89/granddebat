<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $messages = $user->messages()->orderBy('created_at', 'DESC')->get();
        return view('messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        $this->authorize('show', $message);
        $message->read = true;
        $message->save();
        return view('messages.show', compact('message'));
    }
}
