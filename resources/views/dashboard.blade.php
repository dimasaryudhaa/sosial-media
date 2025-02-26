<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <textarea name="body" class="w-full block rounded textarea textarea-bordered @error('body') textarea-error @enderror" placeholder="Write your post"></textarea>
                            @error('body')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <input type="file" name="photo" class="file-input file-input-bordered w-full" accept="image/*">
                            @error('photo')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>                    
                </div>               
            </div>   

            @foreach ($posts as $post)
            <div class="card bg-base-100 w-full shadow-xl my-4">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h2 class="card-title flex items-center gap-2">
                            <img src="{{ $post->user->profile_photo_url }}" alt="Profile" class="w-10 h-10 rounded-full border">
                            <span>{{ $post->user->name }}</span>
                            <span class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                        </h2>
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
    
                    <p class="mt-2">{{ $post->body }}</p>
    
                    @if ($post->photo)
                        <img src="{{ asset('storage/' . $post->photo) }}" class="max-w-xs h-auto rounded-lg">
                    @endif
                </div>
    
                <div class="card-actions mx-4 mb-4 flex items-center justify-start gap-2">
                    <button onclick="likePost({{ $post->id }})" id="like-btn-{{ $post->id }}" class="btn btn-sm btn-outline flex items-center">
                        <i class="fa-solid fa-thumbs-up"></i>
                        <span id="like-count-{{ $post->id }}" class="ml-1">{{ $post->likes_count }}</span>
                    </button>
    
                    <a href="{{ route('post.show', $post->id) }}" class="btn btn-sm btn-outline flex items-center">
                        <i class="fa-solid fa-comment"></i>
                        <span class="ml-1">Comment ({{ $post->comments_count }})</span>
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
