<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Edit Post -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                    Edit Postingan
                </h3>

                <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Input teks -->
                    <textarea 
                        name="body" 
                        rows="4"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-100 resize-none @error('body') border-red-500 @enderror"
                        placeholder="Tulis isi postingan di sini...">{{ old('body', $post->body) }}</textarea>
                    @error('body')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- Gambar yang sudah ada -->
                    @if ($post->photo)
                        <div class="mt-4">
                            <p class="text-gray-600 text-sm mb-2">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $post->photo) }}" class="rounded-lg w-full max-w-md shadow">
                        </div>
                    @endif

                    <!-- Input file (disamakan tampilannya dengan form tambah postingan) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar (Opsional)</label>
                        <input 
                            type="file" 
                            name="photo" 
                            class="block w-full text-sm text-gray-700 
                                   file:mr-4 file:py-2 file:px-4 
                                   file:rounded-lg file:border-0 
                                   file:bg-blue-50 file:text-blue-700 
                                   hover:file:bg-blue-100"
                            accept="image/*">
                        @error('photo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                            <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
