<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use App\Models\Project;

new class extends Component {
    public $search = '';
    public $projects;
    public $project;
    public $project_id;
    public $img = '';

    public function mount()
    {
        $this->project = auth()->user()->default_project ? Project::find(auth()->user()->default_project) : null;
        $this->project_id = null;
        $this->projects = Project::when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%");
        })
            ->where('organization_id', auth()->user()->organization_id)
            ->whereNot('is_archived', true)
            ->orderBy('name', 'ASC')
            ->get(['id', 'name']);
    }

    public function setProject($project_id)
    {
        if (auth()->check() && isset($project_id)) {
            auth()
                ->user()
                ->update(['default_project' => $project_id]);
            $this->redirect(request()->header('Referer'), navigate: true);
        }
    }

    public function updatedSearch()
    {
        $this->refreshList();
    }

    public function refreshList()
    {
        $this->projects = Project::when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%");
        })
            ->where('organization_id', auth()->user()->organization_id)
            ->where('is_archived', false)
            ->orderBy('name', 'ASC')
            ->get(['id', 'name']);
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div x-data="{ open: false }"
    class="relative flex flex-1 items-center justify-between border-b border-gray-200 dark:border-gray-700 h-16 px-8 py-4">
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

    <div class="flex gap-4 items-center">
        {{-- Action Buttons --}}
        <div x-data="{ openModel: false }" @click.outside="openModel = false" @close.stop="openModel = false"
            class="flex relative rounded-md bg-blue-500 dark:bg-blue-800 text-white dark:tex-gray-300 text-sm">
            <a href="{{ url('projects?createProject=true') }}" wire:navigate
                class="flex gap-2 items-center p-2 px-4 border-r border-gray-300 dark:border-gray-500"><i class="fa-solid fa-plus"></i> New Project</a>
            <button @click='openModel = !openModel' class="p-2 px-3"><i class="fa-solid fa-angle-down"></i></button>

            <div x-show='openModel' x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute w-full z-50 mt-10 shadow-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300">
                <div class="flex flex-col">
                    {{-- <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Project</a> --}}
                    <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Module</a>
                    <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Build</a>
                    <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Requirement</a>
                    {{-- <a href=""><i class="fa-solid fa-plus"></i> Test Plan</a> --}}
                    {{-- <a href=""><i class="fa-solid fa-plus"></i> Test Suite</a>
                            <a href=""><i class="fa-solid fa-plus"></i> Test Run</a> --}}
                    <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Test Scenario</a>
                    <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Test Case</a>
                    <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Defect</a>
                </div>
            </div>
        </div>

        <div>
            <!-- Darkmode Toggler -->
            <button x-on:click="darkMode = !darkMode" type="button"
                class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                <svg x-show="! darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>

        </div>

        <!-- Profile Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <div class="flex items-center gap-4 cursor-pointer">
                        <p>{{ auth()->user()->name }}</p>
                        @if (auth()->user()->avatar)
                            <img class="w-10 h-10 object-cover object-center rounded-full" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                        @else
                            <img class="w-10 h-10 object-cover object-center rounded-full" src="{{ asset('storage/images/avatar/default.jpg') }}" alt="">
                        @endif
                    </div>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <button wire:click="logout" class="w-full text-start">
                        <x-dropdown-link>
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </button>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</div>
