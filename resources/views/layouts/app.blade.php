<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- jQuery & Datatables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white shadow-md fixed top-0 left-0 h-screen flex flex-col justify-between">
            <div>
                <!-- Logo -->
                <div class="p-6 border-b">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-gray-800 font-bold text-xl">
                        <x-application-logo class="h-8 w-8 fill-current text-blue-600" />
                        <span>{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <!-- Menu -->
                <nav class="mt-4 space-y-1 px-4">
                    <a href="{{ route('dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-100 {{ request()->routeIs('dashboard') ? 'bg-blue-200 font-semibold' : '' }}">
                        <i class="fa-solid fa-house mr-2"></i> Beranda
                    </a>

                    <a href="{{ route('post.create') }}"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-100 {{ request()->routeIs('post.create') ? 'bg-blue-200 font-semibold' : '' }}">
                        <i class="fa-solid fa-pen-to-square mr-2"></i>Buat
                    </a>

                    <a href="{{ route('profile.edit') }}"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-100 {{ request()->routeIs('profile.edit') ? 'bg-blue-200 font-semibold' : '' }}">
                        <i class="fa-solid fa-user-circle mr-2"></i> Profil
                    </a>
                </nav>

            </div>

            <!-- Tombol Logout (lebih ke atas agar terlihat) -->
            <div class="p-4 border-t mb-8">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-red-100">
                        <i class="fa-solid fa-right-from-bracket mr-2 text-red-500"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>


        <!-- KONTEN UTAMA -->
        <div class="flex-1">
            <!-- Header (opsional) -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Konten -->
            <main class="p-6">
                {{-- @if (session('success'))
                    <div class="bg-green-500 text-white p-3 rounded flex items-center shadow-lg mb-4">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif --}}

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
