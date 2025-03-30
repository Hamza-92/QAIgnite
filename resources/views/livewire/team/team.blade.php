<div>
    @if (session()->has('message'))
        <div class="px-4 py-2 bg-green-500 text-white rounded-md mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="px-4 py-2 bg-red-500 text-white rounded-md mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div
        class="px-8 py-4 flex gap-4 flex-wrap items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl">Team Management</h2>
        <a href="{{ route('users', ['createUser' => true]) }}" wire:navigate
            class="px-4 py-2 bg-blue-500 dark:bg-blue-600 text-white hover:bg-blue-600 dark:hover:bg-blue-500 rounded-md cursor-pointer">Add
            User</a>
    </div>

    {{-- Data Table --}}
    {{-- Users --}}
    <div class="px-4 md:px-8 py-4">
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-4 items-center flex-col md:flex-row">
                <button
                    class="px-4 py-2 bg-blue-500 dark:bg-blue-600 text-white hover:bg-blue-600 dark:hover:bg-blue-500 rounded-md cursor-pointer w-full md:w-auto"
                    type="button" wire:click='saveTeam'>Save Team</button>
                <x-table-entries entries="perPage" class="w-full md:w-auto" />
            </div>
            <div class="flex flex-wrap items-center gap-4">

                <div class="relative">
                    <select wire:model.live="userType"
                        class="appearance-none h-9 py-1 pl-2 pr-8 text-sm rounded-md border dark:bg-gray-900 dark:border-gray-700">
                        <option value="">All</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                        <i wire:loading wire:target="userType" class="fa-solid fa-spinner fa-spin"></i>
                        <svg wire:loading.remove wire:target="userType" class="fill-current h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </div>
                <x-search-field search='search' resetMethod='resetSearch' />
            </div>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                        <tr>
                            <th class="px-4 py-3 font-medium"></th>
                            <x-sortable-th name="name" displayName="Name" :sortBy="$sortBy" :sortDir="$sortDir" />
                            <x-sortable-th name="email" displayName="Email" :sortBy="$sortBy" :sortDir="$sortDir" />
                            <x-sortable-th name="role.name" displayName="Role" :sortBy="$sortBy" :sortDir="$sortDir" />
                            <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr wire:key='{{ $user->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                                <td class="px-4 py-3"><input type="checkbox" name="" id="{{ $user->id }}"
                                        value="{{ $user->id }}" wire:model.differ='selected_user_ids'
                                        class="cursor-pointer"></td>
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">{{ $user->role->name }}</td>
                                <td class="px-4 py-3">{{ $user->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="w-full p-4 text-center" colspan="5">No Records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div>{{ $users->links() }}</div>
    </div>
</div>
