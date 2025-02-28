<div class="" x-data="{ invitationID: null, confirmationModel: false, userID: null }">
    <div class="px-8 py-4 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl">User Management</h2>
        <button wire:click='createInvitation'
            class="px-4 py-2 bg-blue-500 dark:bg-blue-800 text-white dark:text-gray-200 hover:bg-blue-600 dark:hover:bg-blue-900 rounded-md cursor-pointer">Create
            User</button>
    </div>

    {{-- Users --}}
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

                <select wire:model.live="userType"
                    class="h-10 text-sm rounded-md border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                    <option value="">All</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <input wire:model.live.debounce.300='search'
                    class="border-gray-200 rounded-md text-sm dark:bg-gray-900 dark:border-gray-700" type="text"
                    placeholder="search...">
            </div>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700">
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
        <div>{{ $users->links() }}</div>
    </div>

    <hr class="w-full my-4 border-gray-200 dark:border-gray-700">

    {{-- Invited Users --}}
    <div class="px-8 py-4">
        <h2 class="text-xl mb-4 ">Invited Users</h2>
        <div class="flex items-center justify-between">
            <div class="flex gap-1 items-center">
                <p>Show</p>
                <select wire:model.live='invitationPerPage'
                    class="h-8 py-1 text-sm rounded-md border-gray-200 dark:bg-gray-900 dark:border-gray-700"
                    name="invitationPerPage" id="invitationPerPage">
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select>
                <p>entries</p>
            </div>
            <div class="flex items-center gap-4">

                <select wire:model.live="invitationUserType"
                    class="h-10 text-sm rounded-md border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                    <option value="">All</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <input wire:model.live.debounce.300='invitationSearch'
                    class="border-gray-200 rounded-md text-sm dark:bg-gray-900 dark:border-gray-700" type="text"
                    placeholder="search...">
            </div>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700">
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
                                            <i class="fa-solid fa-retweet"></i>
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
                <button @click='invitationID ? $wire.deleteInvitation(invitationID) : $wire.deleteUser(userID); confirmationModel = false' type="button"
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
            <div class="px-8 py-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg" x-text="$wire.createUser ? 'Create New User' : 'Edit User'"></h3>
                <button wire:click="resetForm" class="text-xl"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="flex flex-col p-8">
                <form wire:submit.prevent='save'>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label>Name<span class="text-red-500">*</span></label>
                            <input wire:model='name' type="text" name="name" id="name"
                                class="rounded-md border-gray-200 dark:bg-gray-700 dark:border-gray-700 text-sm">
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-1">
                            <label>Email<span class="text-red-500">*</span></label>
                            <input wire:model='email' type="email" name="email" id="email"
                                class="rounded-md border-gray-200 dark:bg-gray-700 dark:border-gray-700 text-sm">
                            @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-1">
                            <label>Role<span class="text-red-500">*</span></label>
                            <select wire:model='role' name="role" id="role"
                                class="rounded-md border-gray-200 dark:bg-gray-700 dark:border-gray-700 text-sm">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-4 mt-8">
                        <button type="submit" id="saveButton" wire:click="save"
                            class="px-4 py-2 rounded-md bg-blue-500 hover:bg-blue-600 text-gray-100 dark:bg-blue-800 dark:hover:bg-blue-900">
                            Save
                            <i wire:loading wire:target="save" class="fa-solid fa-spinner"></i>
                        </button>
                        <button wire:click='resetForm' type="button" id="cancelButton"
                            class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-900 dark:bg-gray-700 dark:hover:bg-gray-800 dark:text-gray-100">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
