<div x-data = "{confirmationModel : false, buildid : null}" class="w-full h-full">

    {{-- Heading --}}
    <div
        class="px-8 py-4 flex gap-4 flex-wrap items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl">Build Management</h2>
        <button x-on:click="$wire.createBuild = true"
            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md cursor-pointer"
            type="button">Create Build</button>
    </div>

    {{-- Table --}}
    <div class="px-8 py-4">
        <div class="flex items-center justify-between">
            {{-- Table per page --}}
            <x-table-entries entries="perPage" />

            {{-- Search field --}}
            <div class="flex items-center gap-4">
                <x-search-field search='search' placeholder='Search...' resetMethod='resetSearch' />
            </div>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <x-sortable-th name="name" displayName="Build" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <x-sortable-th name="description" displayName="Description" :sortBy="$sortBy"
                            :sortDir="$sortDir" />
                            <x-sortable-th name="start_date" displayName="Start Date" :sortBy="$sortBy" :sortDir="$sortDir" />
                            <x-sortable-th name="end_date" displayName="End Date" :sortBy="$sortBy" :sortDir="$sortDir" />
                            <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($builds as $build)
                        <tr wire:key='{{ $build->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">{{ $build->name }}</td>
                            <td class="px-4 py-3" title="{{ $build->description }}">{{ Str::limit($build->description, 30, '...') }}</td>
                            <td class="px-4 py-3">{{ optional($build->start_date)->format('d-M-Y') }}</td>
                            <td class="px-4 py-3">{{ optional($build->end_date)->format('d-M-Y') }}</td>
                            <td class="px-4 py-3">{{ $build->created_at->format('d-M-Y') }}</td>
                            <td class="px-4 py-3 flex justify-center whitespace-nowrap">
                                <div class="relative" x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="px-4 py-1 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 cursor-pointer">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-transition
                                        class="absolute top-1/2 right-full mr-3 transform -translate-y-1/2 p-1 text-md bg-white dark:bg-gray-800 rounded-md border dark:border-gray-700 shadow-lg z-10 flex items-center justify-center gap-2 before:absolute before:top-1/2 before:left-full before:-translate-y-1/2 before:w-0 before:h-0 before:border-[6px] before:border-t-transparent before:border-b-transparent before:border-l-white dark:before:border-l-gray-800 before:border-r-transparent">
                                        <!-- Edit Button -->
                                        <button
                                            class="px-2 py-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors border-r dark:border-gray-700 cursor-pointer"
                                            type="button" title="Edit Build" wire:click="edit({{ $build->id }})">
                                            <i wire:loading.remove wire:target="edit({{ $build->id }})"
                                                class="fa-solid fa-pen-to-square"></i>
                                            <i wire:loading wire:target="edit({{ $build->id }})"
                                                class="fa-solid fa-spinner fa-spin"></i>
                                        </button>

                                        {{-- Delete Button --}}
                                        <button @click="confirmationModel = true; buildid = {{ $build->id }}"
                                            title="Delete Build"
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
        <div>{{ $builds->links() }}</div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div x-show="confirmationModel" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @keydown.escape.window="confirmationModel = false; buildid = null"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 dark:bg-gray-100/50"
        style="display: none;">
        <div
            class="flex flex-col items-center text-center bg-white dark:bg-gray-900 rounded-lg p-6 w-full max-w-md mx-auto shadow-lg">
            <div class="text-red-500 mb-2 text-3xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Build</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">Are you sure you want to delete this Build and its
                associated data?</p>
            <p class="text-sm text-gray-700 dark:text-gray-300">Remember! this action cannot be undone.</p>

            <div class="mt-6 space-x-3">
                <button type="button" @click="$wire.delete(buildid); confirmationModel = false; buildid = null"
                    class="px-5 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500 focus:ring-2 focus:ring-red-400">
                    Delete
                </button>
                <button type="button" @click="confirmationModel = false; buildid = null"
                    class="px-5 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    {{-- Build Form --}}
    <div x-show="$wire.createBuild || $wire.editBuild" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute z-50 top-0 left-0 w-full h-full bg-gray-900/50 dark:bg-gray-100/50" id="form" x-cloak>
        <div class="absolute w-full h-full max-w-3xl top-0 right-0 bg-white dark:bg-gray-900 overflow-y-auto">
            <div
                class="sticky top-0 px-8 z-50 py-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <h3 class="text-lg" x-text="$wire.createBuild ? 'Create New Build' : 'Edit Build'"></h3>
                <button wire:click='resetForm' class="text-xl"><i class="fa-solid fa-xmark cursor-pointer"></i></button>
            </div>
            <div class="flex flex-col p-4 sm:p-8">
                <form wire:submit.prevent='save'>
                    <div class="grid sm:grid-cols-2 gap-4">
                        {{-- Build ID --}}
                        <x-input-field label='Name' model='name' type='text' required='true'
                            autocomplete='project-name' />

                        {{-- Start Date --}}
                        <div wire:ignore x-data x-init="flatpickr($refs.startDate, {
                            altInput: true,
                            altFormat: 'F j, Y',
                            dateFormat: 'Y-m-d',
                            minDate: 'today',
                            onChange: function(selectedDates, dateStr) {
                                $dispatch('start-date-changed', dateStr)
                            }
                        })">
                            <label for="start_date">Start Date</label>
                            <div class="relative">
                                <input x-ref="startDate" type="text"
                                    class="mt-1 px-4 py-2 block w-full rounded-md border dark:border-gray-700"
                                    wire:model.defer="start_date" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fa-regular fa-calendar-days text-gray-500"></i>
                                </div>
                            </div>
                            @error('start_date')
                                <span class="text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- End Date --}}
                        <div wire:ignore x-data="{ endPicker: null, minDate: @entangle('start_date') }" x-init="endPicker = flatpickr($refs.endDate, {
                            altInput: true,
                            altFormat: 'F j, Y',
                            dateFormat: 'Y-m-d',
                            minDate: minDate,
                            onChange: function(selectedDates, dateStr) {
                                $dispatch('input', dateStr)
                            }
                        });

                        $watch('minDate', value => {
                            endPicker.set('minDate', value);
                        });

                        $el.addEventListener('start-date-changed', e => {
                            minDate = e.detail;
                        });">
                            <label for="end_date">End Date</label>
                            <div class="relative">
                                <input x-ref="endDate" type="text"
                                    class="mt-1 px-4 py-2 block w-full rounded-md border dark:border-gray-700 pr-10"
                                    wire:model.defer="end_date" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fa-regular fa-calendar-days text-gray-500"></i>
                                </div>
                            </div>
                            @error('end_date')
                                <span class="text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Description --}}
                    <x-textarea model='description' label='Description' class="mt-4" rows='5' />

                    <div class="flex items-center justify-center gap-4 mt-8">
                        <button type="submit" wire:loading.attr='disabled'
                            class="px-8 py-3 text-xl sm:w-42 transition duration-200 rounded-md bg-blue-500 hover:bg-blue-600 text-xl text-white dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer">Save
                            <i wire:loading wire:target='save' class="fa-solid fa-spinner fa-spin"></i></button>
                        <button wire:click='resetForm' type="button" id="cancelButton"
                            class="px-8 py-3 text-xl sm:w-42 transition duration-200 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 cursor-pointer">
                            Cancel
                            <i wire:loading wire:target='resetForm' class="fa-solid fa-spinner fa-spin"></i></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
