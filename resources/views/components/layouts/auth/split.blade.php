<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="grid lg:grid-cols-2 min-h-screen">
        <div class="m-4 rounded-2xl bg-blue-600 p-8 text-white">
            <div class="flex h-full flex-col items-start justify-between gap-8">
                <div class="flex flex-col gap-8">
                    <a href="{{ route('home') }}" class="flex items-center text-lg font-medium" wire:navigate>
                        <span class="flex h-10 w-10 items-center justify-center rounded-md">
                            <x-app-logo-icon class="mr-2 h-7 fill-current text-white" />
                        </span>
                        {{ config('app.name', 'QA Ignite') }}
                    </a>

                    <div class="hidden mt-10 lg:flex flex-wrap items-center justify-start gap-4">
                        <span class="px-4 py-1 border border-gray-300 rounded-full text-gray-100 text-sm">Test
                            Management</span>
                        <span class="px-4 py-1 border border-gray-300 rounded-full text-gray-100 text-sm">Project
                            Management</span>
                        <span class="px-4 py-1 border border-gray-300 rounded-full text-gray-100 text-sm">Defect
                            Management</span>
                        <span class="px-4 py-1 border border-gray-300 rounded-full text-gray-100 text-sm">Build
                            Management</span>
                        <span class="px-4 py-1 border border-gray-300 rounded-full text-gray-100 text-sm">Requirement
                            Management</span>
                        <span
                            class="px-4 py-1 border border-gray-300 rounded-full text-gray-100 text-sm">Integrations</span>
                        <span class="px-4 py-1 border border-gray-300 rounded-full text-gray-100 text-sm">Collaborative
                            Test Design</span>
                    </div>

                    <!-- Container -->
                    <div class="hidden lg:block relative w-full h-full">

                        <!-- Cursor 1 -->
                        <div class="absolute top-[0px] left-[120px]">
                            <div class="relative">
                                <div
                                    class="w-0 h-0 border-t-[6px] border-t-transparent border-b-[6px] border-b-transparent border-r-[12px] border-r-pink-500 rotate-45">
                                </div>
                                <div
                                    class="absolute top-0 left-4 bg-pink-500 text-white text-xs px-2 py-0.5 rounded shadow whitespace-nowrap">
                                    Hamza
                                </div>
                            </div>
                        </div>

                        <!-- Cursor 2 -->
                        <div class="absolute top-[50px] left-[300px]">
                            <div class="relative">
                                <div
                                    class="w-0 h-0 border-t-[6px] border-t-transparent border-b-[6px] border-b-transparent border-r-[12px] border-r-indigo-400 rotate-45">
                                </div>
                                <div
                                    class="absolute top-0 left-4 bg-indigo-500 text-white text-xs px-2 py-0.5 rounded shadow whitespace-nowrap">
                                    Aiman
                                </div>
                            </div>
                        </div>

                        <!-- Cursor 3 -->
                        <div class="absolute top-[-20px] left-[450px]">
                            <div class="relative">
                                <div
                                    class="w-0 h-0 border-t-[6px] border-t-transparent border-b-[6px] border-b-transparent border-r-[12px] border-r-teal-400 rotate-45">
                                </div>
                                <div
                                    class="absolute top-0 left-4 bg-teal-500 text-white text-xs px-2 py-0.5 rounded shadow whitespace-nowrap">
                                    Aalam
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="mt-auto">
                    <blockquote class="space-y-2 text-gray-100 leading-relaxed">
                        <h3 class="text-2xl md:text-3xl font-medium tracking-tight">
                            {{ trim($message) }}
                        </h3>
                        <footer class="text-gray-400 text-base md:text-sm mt-2">
                            &mdash; {{ trim($author) }}
                        </footer>
                    </blockquote>
                </div>


            </div>
        </div>

        {{-- Form --}}
        <div class="w-full p-4 lg:p-8">
            <div class="mx-auto flex w-full h-full flex-col justify-center space-y-6 sm:w-[350px]">
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
