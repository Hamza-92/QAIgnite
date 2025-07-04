<header
    class="min-h-16 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between px-4 sm:px-8 py-2">
    <div x-data="{ open: false }"
        class="flex flex-1 flex-col-reverse sm:flex-row gap-4 sm:gap-8 items-center justify-between w-full">
        <!-- Project Dropdown -->
        <div class="relative w-full sm:w-72" @click.outside="open = false" @close.stop="open = false">
            <div @click="open = !open; if(open) $wire.refreshList();" x-data="{ glow: @json(session('blink_component')) }" x-init="if (glow) {
                let el = $el;
                el.classList.add('animate-pulse-bg');
                setTimeout(() => {
                    el.classList.remove('animate-pulse-bg');
                }, 5000);
            }"
                class="flex items-center justify-between gap-4 bg-blue-100 dark:bg-blue-900/50 rounded-xl px-4 py-2 w-full sm:w-72 transition-colors">
                <p class="text-sm">Project:
                    <span class="font-medium">
                        @isset($project)
                            {{ $project->name }}
                        @else
                            Select a Project
                        @endisset
                    </span>
                </p>
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute z-50 mt-2 w-full sm:w-72 shadow-lg dark:bg-gray-800 max-h-80 overflow-auto">
                <div class="border-b dark:border-gray-700">
                    <input wire:model.live.debounce.300='search' type="text"
                        class="w-full px-4 py-3 text-sm bg-white dark:bg-gray-800 outline-none border-none"
                        placeholder="Type to search">
                </div>
                <div>
                    @forelse ($projects as $project)
                        <button id="{{ $project->id }}" wire:click='setProject({{ $project->id }})'
                            class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                            {{ $project->name }}
                            @if ($project->id == auth()->user()->default_project)
                                <i class="fa-solid fa-check text-green-500"></i>
                            @endif
                        </button>
                    @empty
                        <p class="py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700">
                            No project found</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Action Buttons & Profile -->
        <div class="flex gap-4 items-center justify-between sm:justify-end w-full sm:w-auto">
            {{-- Ai Test Case Generator --}}
            <a href="{{ route('ai-test-case-generator') }}" title="AI Test Case Generator" wire:navigate
                class="px-2 py-1 rounded-md bg-green-100 dark:bg-green-900/50 text-green-500 hover:text-green-600 dark:hover:text-green-600 text-lg"><i
                    class="fa-solid fa-robot"></i></a>
            <!-- New Project Button -->
            <div x-data="{ openModel: false }" @click.outside="openModel = false" @close.stop="openModel = false"
                class="relative flex rounded-md bg-blue-500 dark:bg-blue-600 text-white text-sm ">
                <button type="button" wire:click='createProject' type="button" wire:loading.attr='disabled'
                    class="flex gap-2 items-center p-2 px-4 border-r border-gray-300 dark:border-gray-500 hover:bg-blue-600 dark:hover:bg-blue-500 rounded-l-md w-full sm:w-auto">
                    <i class="fa-solid fa-plus"></i> New Project
                </button>
                <button @click='openModel = !openModel' type="button"
                    class="p-2 px-3 hover:bg-blue-600 dark:hover:bg-blue-500 rounded-r-md cursor-pointer"><i
                        class="fa-solid fa-angle-down"></i></button>

                <div x-show='openModel' x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute w-full z-50 mt-10 shadow-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300">
                    <div class="flex flex-col">
                        <button type="button" wire:click='createBuild' wire:loading.attr='disabled'
                            class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><i
                                class="fa-solid fa-plus"></i> Build</button>
                        <button type="button" wire:click='createModule' wire:loading.attr='disabled'
                            class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><i
                                class="fa-solid fa-plus"></i> Module</button>
                        <button type="button" wire:click='createRequirement' wire:loading.attr='disabled'
                            class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><i
                                class="fa-solid fa-plus"></i> Requirement</button>
                        <button type="button" wire:click='createTestScenario' wire:loading.attr='disabled'
                            class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><i
                                class="fa-solid fa-plus"></i> Test Scenario</button>
                        <button type="button" wire:click='createTestCase' wire:loading.attr='disabled'
                            class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><i
                                class="fa-solid fa-plus"></i> Test Case</button>
                        <button type="button" wire:click='createDefect' wire:loading.attr='disabled'
                            class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><i
                                class="fa-solid fa-plus"></i> Defect</button>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="flex items-center ms-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <div class="flex items-center gap-4 cursor-pointer">
                            <p class="hidden lg:block">{{ auth()->user()->name }}</p>
                            <img class="w-10 h-10 object-cover rounded-full"
                                src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('storage/images/avatar/default.jpg') }}"
                                alt="User Avatar">
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <flux:radio.group class="mt-2" x-data variant="segmented" x-model="$flux.appearance">
                            <flux:radio value="light" icon="sun"></flux:radio>
                            <flux:radio value="dark" icon="moon"></flux:radio>
                            <flux:radio value="system" icon="computer-desktop"></flux:radio>
                        </flux:radio.group>
                        <x-dropdown-link :href="route('profile')" wire:navigate class="mt-1">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <button wire:click="logout" class="w-full text-start mt-1 cursor-pointer">
                            <x-dropdown-link class="rounded-b-md">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</header>
