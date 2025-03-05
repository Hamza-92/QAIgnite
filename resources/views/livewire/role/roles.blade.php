<div>
    <div class="px-8 py-4 flex gap-4 flex-wrap items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl">Role Management</h2>
        <a href="{{ route('role.create') }}" wire:navigate
            class="px-4 py-2 bg-blue-500 dark:bg-blue-600 text-white hover:bg-blue-600 dark:hover:bg-blue-500 rounded-md cursor-pointer">Create
            Role</a>
    </div>

    {{-- Roles --}}
    <div class="px-4 md:px-8 py-4">
        <div class="flex flex-wrap gap-4 items-center justify-between">
            {{-- Table per page --}}
            <x-table-entries entries="perPage" />

            {{-- Search field --}}
            <div class="flex items-center gap-4">
                <x-search-field search='search' placeholder='Search...' resetMethod='resetSearch' />
            </div>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-x-auto">
            <table class="w-full border-collapse text-sm ">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <x-sortable-th name="name" displayName="Role Name" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <x-sortable-th name="description" displayName="Description" :sortBy="$sortBy"
                            :sortDir="$sortDir" />
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
                            <td class="px-4 py-3">
                                <span
                                    class="{{ $role->deletable ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }} px-2 py-1 rounded">
                                    {{ $role->deletable ? 'True' : 'False' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $role->created_at }}</td>
                            <td class="flex items-center justify-center text-center px-4 py-3">
                                @if (!$role->default)
                                    <a href="{{ route('role.edit', ['id' => $role->id]) }}"
                                        class="px-1 py-1 cursor-pointer hover:text-blue-500" type="button"
                                        wire:navigate>
                                        <x-tooltip message='Edit Role'>
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </x-tooltip>
                                    </a>
                                    @if ($role->deletable)
                                        <x-confirmation-modal method='deleteRole' param='{{ $role->id }}'
                                            type='delete' title="Delete Role"
                                            message='Are you sure you want to delete the role? Remember this action cannot be undone.'>
                                            <button class="px-1 py-1 text-red-500" type="button">
                                                <x-tooltip message='Delete Role'>
                                                    <i class="fa-solid fa-trash"></i>
                                                </x-tooltip>
                                            </button>
                                        </x-confirmation-modal>
                                    @endif
                                @else
                                    <span>-</span>
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
