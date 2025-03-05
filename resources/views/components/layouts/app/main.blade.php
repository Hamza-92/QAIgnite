<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="font-sans antialiased min-h-screen min-w-screen text-sm bg-white text-gray-900 bg-white dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
    <div class="flex h-screen w-screen overflow-hidden">

        <!-- Sidebar (Fixed but does not overlap content) -->
        <livewire:layouts.sidebar />

        <!-- Main Content Wrapper -->
        <div class="flex flex-col flex-1 h-screen overflow-hidden">

            <!-- Header (Stays within main content area) -->
            <livewire:layouts.header />

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-auto">
                <div class="max-w-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <x-toaster-hub />
    @fluxScripts
    <script src="https://kit.fontawesome.com/e7da1d2f0a.js" crossorigin="anonymous"></script>
</body>

</html>
