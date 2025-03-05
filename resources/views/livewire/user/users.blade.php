<div class="" x-data="{ invitationID: null, confirmationModel: false, userID: null }">
    <div class="px-8 py-4 flex flex-wrap gap-4 items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl">User Management</h2>

        <x-primary-button type='button' model='createInvitation'>
            Create User
        </x-primary-button>

    </div>

    {{-- Users --}}
    <div class="px-4 md:px-8 py-4">
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <x-table-entries entries="perPage" class="w-full md:w-auto"/>
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
                        <svg wire:loading wire:target="userType" class="fill-current h-4 w-4 animate-spin"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 14.93V17a1 1 0 11-2 0v-.07A6.002 6.002 0 014 11H3a1 1 0 110-2h1a6.002 6.002 0 015-5.93V3a1 1 0 112 0v.07A6.002 6.002 0 0116 9h1a1 1 0 110 2h-1a6.002 6.002 0 01-5 5.93z" />
                        </svg>
                        <svg wire:loading.remove wire:target="userType" class="fill-current h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </div>

                <x-search-field search='search' resetMethod='resetSearch'></x-search-field>
            </div>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                        <tr>
                            <x-sortable-th name="name" displayName="Name" :sortBy="$sortBy" :sortDir="$sortDir" />
                            <x-sortable-th name="email" displayName="Email" :sortBy="$sortBy" :sortDir="$sortDir" />
                            <x-sortable-th name="role.name" displayName="Role" :sortBy="$sortBy" :sortDir="$sortDir" />
                            <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                            <th class="px-4 py-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr wire:key='{{ $user->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">{{ $user->role->name }}</td>
                                <td class="px-4 py-3">{{ $user->created_at }}</td>
                                <td class="text-center px-4 py-3">
                                    <div x-data="{ tooltip: false }" class="relative inline-block">
                                        <button class="px-1 py-1 text-red-500 dark:text-red-500" type="button"
                                            @click='userID = {{ $user->id }}; invitationID = null; confirmationModel = true'
                                            @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <div x-show="tooltip" x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-300"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            class="absolute left-1/2 transform -translate-x-1/2 -top-10 bg-gray-900 text-white text-sm p-2 rounded-md shadow-md whitespace-nowrap">
                                            Delete User
                                        </div>
                                    </div>
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
        </div>
        <div>{{ $users->links() }}</div>
    </div>

    <hr class="w-full my-4 border-gray-200 dark:border-gray-700">

    {{-- Invited Users --}}
    <div class="px-4 md:px-8 py-4">
        <h2 class="text-xl mb-4 ">Invited Users</h2>
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <x-table-entries entries="invitationPerPage" />
            <div class="flex flex-wrap items-center gap-4">

                <div class="relative">
                    <select wire:model.live="invitationUserType"
                        class="h-9 py-1 pl-3 pr-8 text-sm rounded-md border dark:bg-gray-900 dark:border-gray-700 appearance-none">
                        <option value="">All</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                        <svg wire:loading wire:target="invitationUserType" class="fill-current h-4 w-4 animate-spin"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 14.93V17a1 1 0 11-2 0v-.07A6.002 6.002 0 014 11H3a1 1 0 110-2h1a6.002 6.002 0 015-5.93V3a1 1 0 112 0v.07A6.002 6.002 0 0116 9h1a1 1 0 110 2h-1a6.002 6.002 0 01-5 5.93z" />
                        </svg>
                        <svg wire:loading.remove wire:target="invitationUserType" class="fill-current h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </div>

                <x-search-field search='invitationSearch' resetMethod='invitationResetSearch'></x-search-field>

            </div>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                        <tr>
                            <x-sortable-th name="name" displayName="Name" :sortBy="$invitationSortBy" :sortDir="$invitationSortDir" />
                            <x-sortable-th name="email" displayName="Email" :sortBy="$invitationSortBy" :sortDir="$invitationSortDir" />
                            <x-sortable-th name="role.name" displayName="Role" :sortBy="$invitationSortBy" :sortDir="$invitationSortDir" />
                            <x-sortable-th name="created_at" displayName="Invitation Date" :sortBy="$invitationSortBy"
                                :sortDir="$invitationSortDir" />
                            <th class="px-4 py-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invitations as $invitation)
                            <tr wire:key='{{ $invitation->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                                <td class="px-4 py-3">{{ $invitation->name }}</td>
                                <td class="px-4 py-3">{{ $invitation->email }}</td>
                                <td class="px-4 py-3">{{ $invitation->role->name }}</td>
                                <td class="px-4 py-3">{{ $invitation->created_at }}</td>
                                <td class="text-center px-4 py-3">
                                    <div class="flex items-center justify-center gap-1">
                                        <div x-data="{ tooltip: false }" class="relative inline-block">
                                            <button class="px-2 py-1" type="button"
                                                wire:click='resendMail({{ $invitation->id }})'
                                                @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                                <i wire:loading wire:target='resendMail({{ $invitation->id }})'
                                                    class="fa-solid fa-spinner fa-spin"></i>
                                                <i wire:loading.remove wire:target='resendMail({{ $invitation->id }})'
                                                    class="fa-solid fa-retweet"></i>
                                            </button>
                                            <div x-show="tooltip" x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-300"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                class="absolute left-1/2 transform -translate-x-1/2 -top-10 bg-gray-900 text-white text-sm p-2 rounded-md shadow-md whitespace-nowrap">
                                                Resend Mail
                                            </div>
                                        </div>
                                        <div x-data="{ tooltip: false }" class="relative inline-block">
                                            <button class="px-1 py-1" type="button"
                                                wire:click='editInvitation({{ $invitation->id }})'
                                                @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <div x-show="tooltip" x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-300"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                class="absolute left-1/2 transform -translate-x-1/2 -top-10 bg-gray-900 text-white text-sm p-2 rounded-md shadow-md whitespace-nowrap">
                                                Edit Invitation
                                            </div>
                                        </div>
                                        <div x-data="{ tooltip: false }" class="relative inline-block">
                                            <button class="px-1 py-1 text-red-500 dark:text-red-500" type="button"
                                                @click='invitationID = {{ $invitation->id }}; userID = null; confirmationModel = true'
                                                @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div x-show="tooltip" x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-300"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                class="absolute left-1/2 transform -translate-x-1/2 -top-10 bg-gray-900 text-white text-sm p-2 rounded-md shadow-md whitespace-nowrap">
                                                Delete Invitation
                                            </div>
                                        </div>
                                    </div>
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
        </div>
        <div>{{ $invitations->links() }}</div>
    </div>

    {{-- Delete Confirmation --}}
    <div x-show='confirmationModel'
        class="fixed inset-0 flex items-center justify-center bg-gray-900/50 dark:bg-gray-100/50">
        <div class="bg-white dark:bg-gray-900 p-8 rounded-md shadow-md text-center flex flex-col items-center gap-4">
            <i class="fa-solid fa-triangle-exclamation text-2xl text-red-500"></i>
            <div class="py-4">
                <p>Are you sure you want to delete?</p>
                <p>Remember this action cannot be undone.</p>
            </div>
            <div class="flex items-center justify-center gap-4">
                <button
                    @click='invitationID ? $wire.deleteInvitation(invitationID) : $wire.deleteUser(userID); confirmationModel = false'
                    type="button"
                    class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-gray-100 dark:bg-red-800 dark:hover:bg-red-900">Yes</button>
                <button @click='invitationID = null; userID = null; confirmationModel = false' type="button"
                    class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-900 dark:bg-gray-700 dark:hover:bg-gray-800 dark:text-gray-100">No</button>
            </div>
        </div>
    </div>

    {{-- User creation form --}}
    <div x-show="$wire.createUser || $wire.editUser"
        class="absolute top-0 left-0 w-full h-full bg-gray-900/50 dark:bg-gray-100/50" id="form">
        <div class="absolute w-1/2 h-full top-0 right-0 bg-white dark:bg-gray-900">
            <div
                class="px-8 py-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700 cursor-pointer">
                <h3 class="text-lg" x-text="$wire.createUser ? 'Create New User' : 'Edit User'"></h3>
                <button wire:click="resetForm" class="text-xl"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="flex flex-col p-8">
                <form wire:submit.prevent='save'>
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Name Field --}}
                        <x-input-field model='name' label='Name' type='text' required='true' />

                        {{-- Email Field --}}
                        <x-input-field model='email' label='Email' type='email' required='true' />

                        {{-- Role Selector --}}
                        <x-single-select-box model='role' label='Role' name='role' required='true'>
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </x-single-select-box>
                    </div>

                    {{-- Form Footer --}}
                    <div class="flex items-center justify-center gap-4 mt-8">
                        {{-- Submit Button --}}
                        <x-primary-button type='submit' model='save'>
                            Save
                        </x-primary-button>

                        {{-- Cancel Button --}}
                        <button wire:click='resetForm' type="button" id="cancelButton"
                            class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-900 dark:bg-gray-700 dark:hover:bg-gray-800 dark:text-gray-100">Cancel
                            <i wire:loading wire:target='resetForm' class="fa-solid fa-spinner fa-spin"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
