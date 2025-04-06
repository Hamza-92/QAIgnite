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
                        <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                            :sortDir="$sortDir" />
                        <x-sortable-th name="start_date" displayName="Start Date" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <x-sortable-th name="end_date" displayName="End Date" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($builds as $build)
                        <tr wire:key='{{ $build->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">{{ $build->name }}</td>
                            <td class="px-4 py-3">{{ $build->description }}</td>
                            <td class="px-4 py-3">{{ $build->created_at->format('d-M-Y') }}</td>
                            <td class="px-4 py-3">{{ optional($build->start_date)->format('d-M-Y') }}</td>
                            <td class="px-4 py-3">{{ optional($build->end_date)->format('d-M-Y') }}</td>
                            <td class="text-center px-4 py-3">
                                <div class="flex items-center justify-center gap-1">
                                    <button class="px-2 py-1 hover:text-blue-500 cursor-pointer" type="button" title="Edit Build"
                                        wire:click="edit({{ $build->id }})">
                                        <i wire:loading.remove wire:target="edit({{ $build->id }})"
                                            class="fa-solid fa-pen-to-square"></i>
                                        <i wire:loading wire:target="edit({{ $build->id }})"
                                            class="fa-solid fa-spinner fa-spin"></i>
                                    </button>
                                    <button @click="confirmationModel = true; buildid = {{ $build->id }}" title="Delete Build"
                                        class="px-2 py-1 text-red-500 cursor-pointer">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
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
    {{-- Delete Confirmation Model --}}
    <div>
        <div x-show="confirmationModel"
            class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900/50 dark:bg-gray-100/50">
            <div class="bg-white rounded-lg dark:bg-gray-700 shadow-lg p-8">
                <p>Are you sure you want to delete? This action cannot be undone.</p>
                <div class="flex gap-4 items-center justify-center mt-4">
                    <button @click="$wire.delete(buildid); confirmationModel = false; buildid = null"
                        class="px-4 py-2 bg-red-500 text-gray-100 rounded-md cursor-pointer">Delete</button>
                    <button @click="confirmationModel = false; buildid = null"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-100 rounded-md cursor-pointer">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Build Form --}}
    <div x-show="$wire.createBuild || $wire.editBuild"
        class="absolute top-0 left-0 w-full h-full bg-gray-900/50 dark:bg-gray-100/50" id="form">
        <div
            class="absolute w-full h-full sm:w-auto sm:w-[640px] md:w-[720px] top-0 right-0 bg-white dark:bg-gray-900 overflow-auto">
            <div class="px-8 py-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg" x-text="$wire.createBuild ? 'Create New Build' : 'Edit Build'"></h3>
                <button wire:click='resetForm' class="text-xl"><i class="fa-solid fa-xmark cursor-pointer"></i></button>
            </div>
            <div class="flex flex-col p-4 sm:p-8">
                <form wire:submit.prevent='save'>
                    <div class="grid sm:grid-cols-2 gap-4">
                        {{-- Build ID --}}
                        <x-input-field label='Name' model='name' type='text' required='true'
                            autocomplete='project-name' />

                        <!-- Start Date -->
                        <div class="flex flex-col gap-1 w-full" x-data="{ startPicker: null }" x-init="startPicker = flatpickr($refs.startDate, {
                            minDate: 'today',
                            dateFormat: 'd-M-Y',
                            onChange: function(selectedDates, dateStr) {
                                $wire.start_date = dateStr;
                                endPicker.set('minDate', dateStr);
                            }
                        });">
                            <label>Start Date</label>
                            <input type="text" x-ref="startDate" wire:model.live="start_date"
                                class="w-full px-4 py-2 rounded-md border border-gray-200 dark:border-gray-700" />
                            @error('start_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="flex flex-col gap-1 w-full" x-data="{ endPicker: null, startDate: @entangle('start_date') }" x-init="endPicker = flatpickr($refs.endDate, {
                            minDate: startDate || 'today',
                            dateFormat: 'd-M-Y',
                            onChange: function(selectedDates, dateStr) {
                                $wire.end_date = dateStr;
                            }
                        });">
                            <label class="block">End Date</label>
                            <input type="text" x-ref="endDate" wire:model.live="end_date"
                                class="w-full px-4 py-2 rounded-md border border-gray-200 dark:border-gray-700" />
                            @error('end_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Description --}}
                    <x-textarea model='description' label='Description' class="mt-4" />

                    <div class="flex items-center justify-center gap-4 mt-4">
                        <button type="submit"
                            class="px-4 py-2 rounded-md bg-blue-500 hover:bg-blue-600 text-white dark:bg-blue-600 dark:hover:bg-blue-500 dark:text-gray-300 cursor-pointer">Save
                            <i wire:loading wire:target='save' class="fa-solid fa-spinner fa-spin"></i></button>
                        <button wire:click='resetForm' type="button" id="cancelButton"
                            class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 cursor-pointer">Cancel
                            <i wire:loading wire:target='resetForm' class="fa-solid fa-spinner fa-spin"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
