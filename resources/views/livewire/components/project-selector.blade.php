<div x-data="{ open: false }"
    class="relative flex flex-1 items-center justify-between {{$class}}">
    <div class="" @click.outside="open = false" @close.stop="open = false">
        <div @click="open = !open; if(open) $wire.refreshList();"
            class="flex items-center justify-between gap-4 bg-blue-100 dark:bg-blue-900/50 rounded-xl px-4 py-2 w-72">
            <p>Project:
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
            class="absolute z-50 mt-2 w-72 shadow-lg dark:bg-gray-800 max-h-80 overflow-auto">
            <div class="border-b dark:border-gray-700">
                <input wire:model.live.debounce.300='search' type="text" name="search"
                    class="w-full px-4 py-3 text-sm bg-white dark:bg-gray-800 outline-none focus:outline-none border-none focus:border-none focus:ring-none"
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
                    <p
                        class="py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                        No project found</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
