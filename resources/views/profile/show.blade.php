<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl ml-72 mx-auto bg-white shadow sm:rounded-lg">

            <!-- Cover -->
            <div class="relative">
                @if($user->cover_photo)
                    <img src="{{ asset('storage/' . $user->cover_photo) }}" class="w-full h-64 object-cover rounded-t-lg">
                @else
                    <div class="w-full h-64 bg-gray-300 flex items-center justify-center rounded-t-lg">
                        <span class="text-gray-500">No Cover Photo</span>
                    </div>
                @endif

                <!-- Foto Profil -->
                <div class="absolute left-1/2 transform -translate-x-1/2 -bottom-12 text-center">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-28 h-28 rounded-full border-4 border-white shadow-md">
                    @else
                        <div class="w-28 h-28 bg-gray-400 rounded-full flex items-center justify-center border-4 border-white shadow-md">
                            <span class="text-white text-sm">No Profile</span>
                        </div>
                    @endif
                    <h3 class="text-lg font-semibold mt-2">{{ $user->name }}</h3>
                </div>
            </div>

            <!-- Postingan User -->
            <div class="mt-16 px-6 pb-8">
                <h3 class="text-xl font-semibold mb-5">Postingan {{ $user->name }}</h3>

                @forelse ($posts as $post)
                    <div class="border rounded-lg p-4 shadow mb-4 relative">
                        <p class="mt-2">{{ $post->body }}</p>

                        @if ($post->photo)
                            <img src="{{ asset('storage/' . $post->photo) }}" class="max-w-xs h-auto rounded-lg mt-2">
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada postingan.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
