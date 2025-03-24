<div x-data="{ open: window.innerWidth > 768 }" class="flex h-screen ">
    <!-- Sidebar -->
    <aside :class="open ? 'w-64' : 'w-20'"
           class="h-screen border-r border-gray-200 dark:border-gray-700
                  transition-all duration-300 ease-in-out flex flex-col">

        <!-- Logo & Toggle -->
        <div class="flex items-center h-16 justify-between px-4 border-b border-gray-200 dark:border-gray-700">
            <a x-show="open" href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <x-application-logo />
            </a>
            <button @click="open = !open"
                    class="p-2 ml-1 rounded-md text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-6 h-6 dark:fill-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 flex flex-col p-4 space-y-2 overflow-y-auto">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
            <i class="fa-solid fa-tachometer-alt"></i>
            <span x-show="open">Dashboard</span>
            </x-nav-link>

            {{-- Project Management --}}
            <x-nav-link :href="route('projects')" :active="request()->routeIs('projects') | request()->routeIs('projects.archive')" wire:navigate>
            <i class="fa-solid fa-project-diagram"></i>
            <span x-show="open">Project Management</span>
            </x-nav-link>

            {{-- Team Management --}}
            <x-nav-link :href="route('team')" :active="request()->routeIs('team')" wire:navigate>
            <i class="fa-solid fa-users"></i>
            <span x-show="open">Team Management</span>
            </x-nav-link>

            {{-- Builds Management --}}
            <x-nav-link :href="route('builds')" :active="request()->routeIs('builds')" wire:navigate>
            <i class="fa-solid fa-cogs"></i>
            <span x-show="open">Build Management</span>
            </x-nav-link>

            {{-- Modules Management --}}
            <x-nav-link :href="route('modules')" :active="request()->routeIs('modules')" wire:navigate>
            <i class="fa-solid fa-cube"></i>
            <span x-show="open">Module Management</span>
            </x-nav-link>

            {{-- Requirement Management --}}
            <x-nav-link :href="route('requirements')" :active="request()->routeIs('requirements')" wire:navigate>
            <i class="fa-solid fa-cube"></i>
            <span x-show="open">Requirements</span>
            </x-nav-link>

            {{-- Role Management --}}
            <x-nav-link :href="route('roles')" :active="request()->routeIs('roles') | request()->routeIs('role.create')  | request()->routeIs('role.edit')" wire:navigate>
            <i class="fa-solid fa-user-shield"></i>
            <span x-show="open">Role Management</span>
            </x-nav-link>

            {{-- User Management --}}
            <x-nav-link :href="route('users')" :active="request()->routeIs('users')" wire:navigate>
            <i class="fa-solid fa-user-cog"></i>
            <span x-show="open">User Management</span>
            </x-nav-link>
        </nav>

        <!-- Logout -->
        <div class="border-t border-gray-200 dark:border-gray-700 mb-2">
            <div class="px-4 pt-2">
                <button wire:click="logout"
                        class="w-full flex items-center gap-3 p-2 px-4 font-medium rounded-lg text-red-600 focus:outline-none
                               hover:bg-red-500 hover:text-white dark:hover:bg-red-900 transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span x-show="open">Log Out</span>
                </button>
            </div>
        </div>
    </aside>
</div>
