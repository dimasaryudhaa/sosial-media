<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Notification;
use App\Models\Comment;

class StoreCommentController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:140'],
        ]);

        $data['user_id'] = $request->user()->id;

        $comment = $post->comments()->create($data);

        if ($post->user_id !== $request->user()->id) {
            Notification::create([
                'user_id' => $post->user_id,
                'from_user_id' => $request->user()->id,
                'post_id' => $post->id,
                'notifiable_id' => $comment->id,
                'notifiable_type' => Comment::class,
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil dibuat!');
    }
}
