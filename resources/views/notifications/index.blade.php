<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-bell text-blue-600"></i> Notifikasi
                </h2>

                @forelse ($notifications as $notif)
                    <div class="flex items-center justify-between border-b py-3 {{ $notif->is_read ? 'bg-gray-50' : 'bg-blue-50' }}">
                        <div>
                            <p class="text-gray-700">
                                <a href="{{ route('profile.show', $notif->fromUser->id) }}" class="font-semibold hover:underline">
                                    {{ $notif->fromUser->name }}
                                </a>
                                @if ($notif->notifiable_type === App\Models\Like::class)
                                    menyukai postingan kamu
                                @elseif ($notif->notifiable_type === App\Models\Comment::class)
                                    mengomentari postingan kamu
                                @endif
                                {{-- :
                                <a href="{{ route('post.show', $notif->post_id) }}" class="text-blue-600 hover:underline">
                                    lihat postingan
                                </a> --}}
                            </p>
                            <p class="text-sm text-gray-500">{{ $notif->created_at->diffForHumans() }}</p>
                        </div>

                        @if (!$notif->is_read)
                            <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-blue-600 hover:underline">Tandai dibaca</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada notifikasi.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
