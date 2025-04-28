<div x-data = "{confirmationModel : false, moduleid : null}" class="w-full h-full">

    {{-- Heading --}}
    <div class="px-8 py-4 flex-wrap gap-2 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl">Modules Management</h2>
        <button x-on:click="$wire.createModule = true"
            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md cursor-pointer"
            type="button">Create Module</button>
    </div>

    {{-- Table --}}
    <div class="px-8 py-4">
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <x-table-entries entries="perPage" />
            <x-search-field search='search' resetMethod='resetSearch'></x-search-field>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <th class="px-4 py-3 font-medium text-left">Build ID</th>
                        <x-sortable-th name="module_name" displayName="Module" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <x-sortable-th name="module_description" displayName="Description" :sortBy="$sortBy"
                            :sortDir="$sortDir" />
                        <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                            :sortDir="$sortDir" />
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($modules as $module)
                        <tr wire:key='{{ $module->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3" title="{{ $module->build->name ?? '' }}">{{ $module->build->name ?? '' }}</td>
                            <td class="px-4 py-3" title="{{ $module->module_name }}">{{ $module->module_name }}</td>
                            <td class="px-4 py-3" title="{{ $module->module_description }}">
                                {{ Str::limit($module->module_description, 30, '...') }}
                            </td>
                            <td class="px-4 py-3">{{ $module->created_at->format('d-M-Y') }}</td>
                            <td class="px-4 py-3 flex justify-center whitespace-nowrap">
                                <div class="relative" x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="px-4 py-1 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 cursor-pointer">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-transition
                                        class="absolute top-1/2 right-full mr-3 transform -translate-y-1/2 p-1 text-md bg-white dark:bg-gray-800 rounded-md border dark:border-gray-700 shadow-lg z-10 flex items-center justify-center gap-2 before:absolute before:top-1/2 before:left-full before:-translate-y-1/2 before:w-0 before:h-0 before:border-[6px] before:border-t-transparent before:border-b-transparent before:border-l-white dark:before:border-l-gray-800 before:border-r-transparent">
                                        <!-- Edit Button -->
                                        <button wire:click="edit({{ $module->id }})" title="Edit"
                                            class="px-2 py-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors border-r dark:border-gray-700 cursor-pointer">
                                            <i wire:loading.remove wire:target='edit({{ $module->id }})' class="fa-solid fa-edit"></i>
                                            <i wire:loading wire:target="edit({{ $module->id }})"
                                                class="fa-solid fa-spinner fa-spin"></i>
                                        </button>
                                        <button @click="confirmationModel = true; moduleid = {{ $module->id }}" title="Delete"
                                            class="px-2 py-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
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
        <div>{{ $modules->links() }}</div>
    </div>

    {{-- Delete Confirmation Model --}}
    <div>
        <div x-show="confirmationModel" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
            class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900/50 dark:bg-gray-100/50">
            <div class="bg-white rounded-lg dark:bg-gray-800 shadow-lg p-8">
                <p>Are you sure you want to delete? This action cannot be undone.</p>
                <div class="flex gap-4 items-center justify-center mt-4">
                    <button @click="$wire.delete(moduleid); confirmationModel = false; moduleid = null"
                        class="px-4 py-2 bg-red-500 text-gray-100 rounded-md cursor-pointer">Delete</button>
                    <button @click="confirmationModel = false; moduleid = null"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-100 rounded-md cursor-pointer">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div x-show="$wire.createModule || $wire.editModule" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
        class="absolute top-0 left-0 z-50 w-full h-full bg-gray-900/50 dark:bg-gray-100/50" id="form" x-cloak>
        <div class="absolute w-full h-full max-w-3xl top-0 right-0 bg-white dark:bg-gray-900 overflow-auto">
            <div class="sticky top-0 px-8 py-4 z-50 flex justify-between items-center border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <h3 class="text-lg" x-text="$wire.createModule ? 'Create New Module' : 'Edit Module'"></h3>
                <button wire:click='resetForm' class="text-xl cursor-pointer"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="flex flex-col p-8">
                <form wire:submit.prevent='save'>
                    <div class="grid sm:grid-cols-2 gap-4">
                        {{-- Build ID --}}
                        <x-single-select-box label='Build ID' model='build_id' >
                            <option value="">Select Build</option>
                                @forelse ($builds ?? [] as $build)
                                    <option value="{{$build->id}}">{{$build->name}}</option>
                                @empty
                                    <option value="">No records found</option>
                                @endforelse
                        </x-single-select-box>

                        {{-- Module Name --}}
                        <x-input-field label='Module Name' model='module_name' type='text' required='true' autocomplete='module-name' />

                        {{-- Description --}}
                        <x-textarea model='module_description' label='Description' class="col-span-2" rows='5' required='true'/>
                    </div>

                    {{-- Form Footer --}}
                    <div class="flex items-center justify-center gap-4 mt-8">
                        <button type="submit" wire:loading.attr='disabled'
                            class="px-8 py-3 sm:w-42 transition duration-200 rounded-md bg-blue-500 hover:bg-blue-600 text-xl text-white dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer">Save
                            <i wire:loading wire:target='save' class="fa-solid fa-spinner fa-spin"></i></button>
                        <button wire:click='resetForm' type="button" id="cancelButton"
                            class="px-8 py-3 text-xl sm:w-42 transition duration-200 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 cursor-pointer">
                            <span>Cancel</span>
                            <i wire:loading wire:target='resetForm' class="fa-solid fa-spinner fa-spin"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
