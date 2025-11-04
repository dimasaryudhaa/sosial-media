<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index() {
        $users = User::where('id', '!=', Auth::id())->get();
        $currentUser = Auth::user();
        return view('chat.index', compact('users', 'currentUser'));
    }

    public function fetchMessages($id) {
        $messages = Message::where(function ($query) use ($id) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('sender_id', $id)->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        return response()->json([
            'messages' => $messages,
            'currentUser' => Auth::user()
        ]);
    }

    public function sendMessage(Request $request) {
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => $message,
            'currentUser' => Auth::user()
        ]);
    }
}

