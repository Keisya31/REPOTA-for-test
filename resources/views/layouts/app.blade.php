<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>REPOTA</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @include('layouts.navigation')
        <div class="min-h-screen pt-20" style = "background-color: #FAF9F0">
            {{-- Header navigation --}}
            
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style = "background-color: #FAF9F0">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                @if(Auth::check())
                    @if(Auth::user()->role === 'adm')
                        @include('layouts.admin-navbar')
                    @elseif(Auth::user()->role === 'mhs')
                        @include('layouts.mahasiswa-navbar')
                    @endif
                @endif

                <!-- Page Content -->
                <div class="w-full flex-1 flex flex-col md:flex-row lg:flex-row px-8">
                    <main class="flex-1 px-2 pt-10 pb-0">
                        {{ $slot }}
                    </main>
                </div>
            </div>
            {{-- Footer --}}
            @include('layouts.footer')
        </div>
    </body>
</html>