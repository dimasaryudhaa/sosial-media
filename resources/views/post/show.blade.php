<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Post Detail -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ $post->user->name }}
                    </h2>
                    <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-700 leading-relaxed">{{ $post->body }}</p>
            </div>

            <!-- Form Komentar -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                    Tambahkan Komentar
                </h3>
                <form action="{{ route('post.comments.store', $post) }}" method="POST" class="space-y-3">
                    @csrf
                    <textarea 
                        name="body" 
                        rows="3"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-100 resize-none @error('body') border-red-500 @enderror" 
                        placeholder="Tulis komentar Anda di sini..."></textarea>
                    @error('body')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="btn btn-primary w-full sm:w-auto px-6">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Komentar
                    </button>
                </form>
            </div>

            <!-- Daftar Komentar -->
            <div class="space-y-4">
                @forelse ($post->comments as $comment)
                    <div class="bg-white rounded-xl shadow-md p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $comment->user->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="flex items-center gap-2">
                                @can('update', $comment)
                                    <a href="{{ route('post.comments.edit', [$post, $comment]) }}" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                @endcan

                                @can('delete', $comment)
                                    <form action="{{ route('post.comments.destroy', [$post, $comment]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus komentar ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-error btn-sm text-white">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <p class="mt-3 text-gray-700">{{ $comment->body }}</p>
                    </div>
                @empty
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
