<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" x-bind:class="{'dark' : darkMode === true}"  x-init="
    if (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        localStorage.setItem('darkMode', JSON.stringify(true));
    }
    darkMode = JSON.parse(localStorage.getItem('darkMode'));
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'QA Ignite') }}</title>

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-poppins antialiased text-sm text-gray-900 bg-white dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
    <div class="flex h-screen w-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside>
            <livewire:layout.sidebar />
        </aside>

        {{-- Main Content --}}
        <div class="flex flex-col flex-1">
            {{-- Header --}}
            <header>
                <livewire:layout.header />
            </header>

            {{-- Page Content --}}
            <main class="w-full h-full overflow-auto">
                {{ $slot }}
            </main>
        </div>

        {{-- Old Data Code --}}
        {{-- <livewire:layout.navigation /> --}}

        <!-- Page Heading -->
        {{-- @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif --}}

        <!-- Page Content -->
        {{-- <main>
            {{ $slot }}
        </main> --}}
    </div>

    <x-toaster-hub />
    {{-- @livewire('notifications') --}}

    <script src="https://kit.fontawesome.com/e7da1d2f0a.js" crossorigin="anonymous"></script>
</body>

</html>
