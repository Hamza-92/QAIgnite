<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div x-data="{ open: true }" class="flex h-screen ">
    <!-- Sidebar -->
    <aside :class="open ? 'w-64' : 'w-20'" class="px-4 bg-white dark:bg-gray-900  border-r border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out flex flex-col">
        <!-- Logo & Toggle -->
        <div class="flex items-center h-16 justify-between border-b border-gray-200 dark:border-gray-700">
            <a x-show="open" href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <x-application-logo />
                {{-- <span x-show="open" class="font-bold text-blue-600 text-lg">QAignite</span> --}}
            </a>
            <button @click="open = !open" class="p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none dark:hover:bg-gray-700">
                {{-- <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg> --}}
                <svg  class="w-6 h-6 dark:fill-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>

                {{-- <i class="fa-solid fa-bars w-6 h-6"></i> --}}
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 flex flex-col py-4 space-y-2">
            {{-- Dashboard --}}
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                <i class="fa-solid fa-house"></i>
                <span x-show="open">Dashboard</span>
            </x-nav-link>

            {{-- Project Management --}}
            {{-- <x-nav-link :href="route('projects')" :active="request()->routeIs('projects')  || request()->routeIs('projects.archive')" wire:navigate>
                <i class="fa-solid fa-folder"></i>
                <span x-show="open">Project Management</span>
            </x-nav-link> --}}

            {{-- Build Management --}}
            {{-- <x-nav-link :href="route('builds')" :active="request()->routeIs('builds')" wire:navigate>
                <i class="fa-solid fa-folder"></i>
                <span x-show="open">Build Management</span>
            </x-nav-link> --}}

            {{-- Module Management --}}
            {{-- <x-nav-link :href="route('modules')" :active="request()->routeIs('modules')" wire:navigate>
                <i class="fa-solid fa-folder"></i>
                <span x-show="open">Module Management</span>
            </x-nav-link> --}}

            {{-- Requirement Management --}}
            {{-- <x-nav-link :href="route('requirements')" :active="request()->routeIs('requirements')" wire:navigate>
                <i class="fa-solid fa-folder"></i>
                <span x-show="open">Requirements</span>
            </x-nav-link> --}}

            {{-- User Management --}}
            {{-- <x-nav-link :href="route('users')" :active="request()->routeIs('users')" wire:navigate>
                <i class="fa-solid fa-user"></i>
                <span x-show="open">User Management</span>
            </x-nav-link> --}}

            {{-- Role Management --}}
            {{-- <x-nav-link :href="route('roles')" :active="request()->routeIs('roles') || request()->routeIs('create-role')" wire:navigate>
                <i class="fa-solid fa-id-card"></i>
                <span x-show="open">Role Management</span>
            </x-nav-link> --}}

            {{-- Profile Management --}}
            {{-- <x-nav-link :href="route('profile')" :active="request()->routeIs('profile')" wire:navigate>
                <i class="fa-solid fa-user"></i>
                <span x-show="open">Profile</span>
            </x-nav-link> --}}
        </nav>

        <!-- Logout -->
        <div class="border-t border-gray-200 dark:border-gray-700 mb-2">
            <button wire:click="logout" class="w-full flex items-center gap-2 p-2 mt-2 px-4 font-medium rounded-lg text-red-600 focus:outline-none focus:border-red focus:text-red-600 hover:bg-red-500 hover:text-white dark:hover:bg-red-900 dark:hover:text-white transition duration-150 ease-in-out">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span x-show="open">Log Out</span>
            </button>
        </div>
    </aside>
</div>
