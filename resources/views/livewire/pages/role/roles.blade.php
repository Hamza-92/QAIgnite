<div>
    <div class="px-8 py-4 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl">Role Management</h2>
        <a href="{{route('create-role')}}" wire:navigate
            class="px-4 py-2 bg-blue-500 dark:bg-blue-800 text-white dark:text-gray-200 hover:bg-blue-600 dark:hover:bg-blue-900 rounded-md cursor-pointer">Create
            Role</a>
    </div>

    {{-- Roles --}}
    <div class="px-8 py-4">
        <div class="flex items-center justify-between">
            <div class="flex gap-1 items-center">
                <p>Show</p>
                <select wire:model.live='perPage'
                    class="h-8 py-1 text-sm rounded-md border-gray-200 dark:bg-gray-900 dark:border-gray-700"
                    name="perPage" id="perPage">
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select>
                <p>entries</p>
            </div>
            <div class="flex items-center gap-4">
                <input wire:model.live.debounce.300='search'
                    class="border-gray-200 rounded-md text-sm dark:bg-gray-900 dark:border-gray-700" type="text"
                    placeholder="search...">
            </div>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <x-sortable-th name="name" displayName="Role Name" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <x-sortable-th name="description" displayName="Description" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <x-sortable-th name="users" displayName="Users" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <th class="px-4 py-3 font-medium text-left">Deletable</th>
                        <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                            :sortDir="$sortDir" />
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr wire:key='{{ $role->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">{{ $role->name }}</td>
                            <td class="px-4 py-3">{{ $role->description }}</td>
                            <td class="px-4 py-3">{{ $role->users_count }}</td>
                            <td class="px-4 py-3">{{ $role->deletable ? "True" : "False" }}</td>
                            <td class="px-4 py-3">{{ $role->created_at }}</td>
                            <td class="text-center px-4 py-3">
                                <div x-data="{ tooltip: false }" class="relative inline-block">
                                    <button class="px-1 py-1" type="button" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-300"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        class="absolute left-1/2 transform -translate-x-1/2 -top-10 bg-gray-100 dark:bg-gray-800 border border-gray-500 text-sm px-2 py-1 max-w-48 whitespace-nowrap">
                                        Edit Role
                                    </div>
                                </div>
                                @if($role->delatable)
                                <div x-data="{ tooltip: false }" class="relative inline-block">
                                    <button class="px-1 py-1 text-red-500" type="button" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-300"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        class="absolute left-1/2 transform -translate-x-1/2 -top-10 bg-gray-900 text-white text-sm p-2 rounded-md shadow-md whitespace-nowrap">
                                        Delete Role
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full p-4 text-center" colspan="5">No Records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $roles->links() }}</div>
    </div>
</div>
