<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use App\Models\Like;

class StorePostController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:140'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('posts', 'public');
        }

        Post::create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
            'photo' => $photoPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Post berhasil dibuat!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:140'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            if ($post->photo) {
                Storage::disk('public')->delete($post->photo);
            }
            $validated['photo'] = $request->file('photo')->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('dashboard')->with('success', 'Post berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->photo) {
            Storage::disk('public')->delete($post->photo);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post berhasil dihapus!');
    }

    public function like(Post $post)
    {
        $user = auth()->user();

        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            $like = $post->likes()->create(['user_id' => $user->id]);

            if ($post->user_id !== $user->id) {
                Notification::create([
                    'user_id' => $post->user_id, 
                    'from_user_id' => $user->id, 
                    'post_id' => $post->id,
                    'notifiable_id' => $like->id,
                    'notifiable_type' => Like::class,
                ]);
            }
        }

        return response()->json(['likes' => $post->likes()->count()]);
    }
}
