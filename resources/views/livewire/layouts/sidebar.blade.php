<div x-data="{ open: window.innerWidth > 768 }" class="flex h-screen ">
    <!-- Sidebar -->
    <aside :class="open ? 'w-64' : 'w-20'"
        class="h-screen border-r border-gray-200 dark:border-gray-700
                  transition-all duration-300 ease-in-out flex flex-col">

        <!-- Logo & Toggle -->
        <div class="flex items-center h-16 justify-between px-4 border-b border-gray-200 dark:border-gray-700">
            <a x-show="open" href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">QA Ignite</span>
                </div>
            </a>
            <button @click="open = !open"
                class="p-2 ml-1 rounded-md text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-6 h-6 dark:fill-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 flex flex-col p-4 space-y-2 overflow-y-auto">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                <i class="fa-solid fa-tachometer-alt"></i>
                <span x-show="open">Dashboard</span>
            </x-nav-link>

            {{-- Project Management Section Title --}}
            <div class="flex items-center text-gray-500 text-sm uppercase px-4 py-2">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-2" x-show="open">Project Management</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            {{-- Project Management --}}
            <x-nav-link :href="route('projects')" :active="request()->routeIs('projects') | request()->routeIs('projects.archive')" wire:navigate>
                <i class="fa-solid fa-project-diagram"></i>
                <span x-show="open">Projects</span>
            </x-nav-link>

            {{-- Team Management --}}
            <x-nav-link :href="route('team')" :active="request()->routeIs('team')" wire:navigate>
                <i class="fa-solid fa-users"></i>
                <span x-show="open">Team</span>
            </x-nav-link>

            {{-- Builds Management --}}
            <x-nav-link :href="route('builds')" :active="request()->routeIs('builds')" wire:navigate>
                <i class="fa-solid fa-cogs"></i>
                <span x-show="open">Build</span>
            </x-nav-link>

            {{-- Modules Management --}}
            <x-nav-link :href="route('modules')" :active="request()->routeIs('modules')" wire:navigate>
                <i class="fa-solid fa-cube"></i>
                <span x-show="open">Module</span>
            </x-nav-link>

            {{-- Requirement Management --}}
            <x-nav-link :href="route('requirements')" :active="request()->routeIs('requirements') || request()->routeIs('requirement.detail')" wire:navigate>
                <i class="fa-solid fa-cube"></i>
                <span x-show="open">Requirements</span>
            </x-nav-link>

            {{-- Test Case Management Section Title --}}
            <div class="flex items-center text-gray-500 text-sm uppercase px-4 py-2">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-2" x-show="open">Test Case Management</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            {{-- Test Scenarios --}}
            <x-nav-link :href="route('test-scenarios')" :active="request()->routeIs('test-scenarios') || request()->routeIs('test-scenario.detail')" wire:navigate>
                <i class="fa-solid fa-cube"></i>
                <span x-show="open">Test Scenarios</span>
            </x-nav-link>

            {{-- Test Cases --}}
            <x-nav-link :href="route('test-cases')" :active="request()->routeIs('test-cases') || request()->routeIs('test-case.detail') || request()->routeIs('test-case.edit')" wire:navigate>
                <i class="fa-solid fa-cube"></i>
                <span x-show="open">Test Cases</span>
            </x-nav-link>

            {{-- Defect Management Section Title --}}
            <div class="flex items-center text-gray-500 text-sm uppercase px-4 py-2">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-2" x-show="open">Defect Management</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            {{-- Defect Management --}}
            <x-nav-link :href="route('defects')" :active="request()->routeIs('defects') || request()->routeIs('defect.detail') || request()->routeIs('defect.edit')" wire:navigate>
                <i class="fa-solid fa-bug"></i>
                <span x-show="open">Defects</span>
            </x-nav-link>

            {{-- Test Lab Section Title --}}
            <div class="flex items-center text-gray-500 text-sm uppercase px-4 py-2">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-2" x-show="open">Test Lab</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            {{-- Test Cycle --}}
            <x-nav-link :href="route('test-cycles')" :active="request()->routeIs('test-cycles') || request()->routeIs('test-cycle.create') || request()->routeIs('test-cycle.edit') || request()->routeIs('test-cycle.detail')" wire:navigate>
                <i class="fa-solid fa-bug"></i>
                <span x-show="open">Test Cycle</span>
            </x-nav-link>

            {{-- Administration Section Title --}}
            <div class="flex items-center text-gray-500 text-sm uppercase px-4 py-2">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-2" x-show="open">Administration</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            {{-- Role Management --}}
            <x-nav-link :href="route('roles')" :active="request()->routeIs('roles') |
                request()->routeIs('role.create') |
                request()->routeIs('role.edit')" wire:navigate>
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
