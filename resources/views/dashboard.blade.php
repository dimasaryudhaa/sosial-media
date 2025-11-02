<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @foreach ($posts as $post)
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <a href="{{ route('profile.show', $post->user->id) }}">
                                <img src="{{ $post->user->profile_photo_url }}" alt="Profile"
                                    class="w-10 h-10 rounded-full border mr-3 hover:ring-2 hover:ring-blue-400 transition">
                            </a>
                            <div>
                                <a href="{{ route('profile.show', $post->user->id) }}" class="font-semibold hover:underline">
                                    {{ $post->user->name }}
                                </a>

                                <div class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                        </div>

                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="btn btn-sm btn-ghost">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white shadow-md rounded-lg z-10">
                                @can('update', $post)
                                    <a href="{{ route('post.edit', $post) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                @endcan
                                @can('delete', $post)
                                    <form action="{{ route('post.destroy', $post) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Hapus</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <p class="mb-3 text-gray-800">{{ $post->body }}</p>

                    @if ($post->photo)
                        <img src="{{ asset('storage/' . $post->photo) }}" class="w-full max-h-[400px] object-cover rounded-lg mb-3">
                    @endif

                    <div class="flex items-center gap-4">
                        <button onclick="likePost({{ $post->id }})" id="like-btn-{{ $post->id }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fa-solid fa-thumbs-up mr-1"></i>
                            <span id="like-count-{{ $post->id }}">{{ $post->likes_count }}</span>
                        </button>

                        <a href="{{ route('post.show', $post->id) }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fa-solid fa-comment mr-1"></i>
                            Comment ({{ $post->comments_count }})
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function likePost(postId) {
            fetch(`/post/${postId}/like`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({}),
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById(`like-count-${postId}`).innerText = data.likes;
            });
        }
    </script>
</x-app-layout>
