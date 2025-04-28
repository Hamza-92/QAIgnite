<div
    x-data='{
    filter_box : false,
    build_col:false,
    module_col:false,
    requirement_title_col:true,
    requirement_summary_col:true,
    status_col:true,
    created_date_col:true,
    confirmationModel: false,
    requirement_id: null }'>

    <div class="px-8 py-4">
        <div class="flex items-center justify-between flex-wrap gap-4">
            {{-- Items per page --}}
            <x-table-entries entries="perPage" />

            <div class="flex items-center gap-4">
                {{-- Search Field --}}
                <x-search-field search='search' placeholder='Search...' resetMethod='resetSearch' />

                <div x-data='{open_model:false}' @click.outside="open_model = false" @close.stop="open_model = false">
                    <button x-on:click='open_model = !open_model' type="button" title="Select Columns"
                        class="text-2xl text-gray-900 dark:text-gray-100 relative">
                        <i class="fa-solid fa-table-columns"></i>
                    </button>
                    <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-20 z-10 mt-2 rounded-md shadow-lg bg-gray-100 dark:bg-gray-800 max-h-72 overflow-auto">
                        <div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="build_col" id="build_col" type="checkbox" class="dark:bg-gray-700"
                                    x-model="build_col">
                                <label for="build_col" class="pl-4 w-full">Build</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="build_col" id="module_col" type="checkbox" class="dark:bg-gray-700"
                                    x-model="module_col">
                                <label for="module_col" class="pl-4 w-full">Module</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="requirement_title_col" id="requirement_title_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="requirement_title_col">
                                <label for="requirement_title_col" class="pl-4 w-full">Requirement Title</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="requirement_summary_col" id="requirement_summary_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="requirement_summary_col">
                                <label for="requirement_summary_col" class="pl-4 w-full">Requirement Summary</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="status_col" id="status_col" type="checkbox" class="dark:bg-gray-700"
                                    x-model="status_col">
                                <label for="status_col" class="pl-4 w-full">Status</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="created_date_col" id="created_date_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="created_date_col">
                                <label for="created_date_col" class="pl-4 w-full">Created Date</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button x-on:click='filter_box = !filter_box' type="button" title="Filter"
                    class="text-2xl text-gray-900 dark:text-gray-100"><i class="fa-solid fa-filter"></i></button>
            </div>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <template x-if="build_col">
                            <th class="px-4 py-3 text-left font-medium">Build</th>
                        </template>
                        <template x-if="module_col">
                            <th class="px-4 py-3 text-left font-medium">Module</th>
                        </template>
                        <template x-if="requirement_title_col">
                            <x-sortable-th name="requirement_title" displayName="Requirement Title" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="requirement_summary_col">
                            <x-sortable-th name="requirement_summary" displayName="Summary" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="status_col">
                            <x-sortable-th name="status" displayName="Status" :sortBy="$sortBy" :sortDir="$sortDir" />
                        </template>
                        <template x-if="created_date_col">
                            <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requirements as $requirement)
                        <tr wire:key='{{ $requirement->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <template x-if="build_col">
                                <td class="px-4 py-3">{{ $requirement->build->name ?? '' }}</td>
                            </template>
                            <template x-if="module_col">
                                <td class="px-4 py-3">{{ $requirement->module->module_name ?? '' }}</td>
                            </template>
                            <template x-if="requirement_title_col">
                                <td class="px-4 py-3" title="{{ $requirement->requirement_title }}">
                                    {{ $requirement->requirement_title }}</td>
                            </template>
                            <template x-if="requirement_summary_col">
                                <td class="px-4 py-3" title="{{ $requirement->requirement_summary }}">
                                    {{ Str::limit($requirement->requirement_summary, 30, '...') }}
                                </td>
                            </template>
                            <template x-if="status_col">
                                <td class="px-4 py-3" title="{{ $requirement->status }}">
                                    {{ $requirement->status ?? '' }}</td>
                            </template>
                            <template x-if="created_date_col">
                                <td class="px-4 py-3">{{ $requirement->created_at->format('d-M-Y') }}</td>
                            </template>
                            <td class="px-4 py-3 flex justify-center whitespace-nowrap">
                                <div class="relative" x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="px-4 py-1 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 cursor-pointer">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-transition
                                        class="absolute top-1/2 right-full mr-3 transform -translate-y-1/2 p-1 text-md bg-white dark:bg-gray-800 rounded-md border dark:border-gray-700 shadow-lg z-10 flex items-center justify-center gap-2 before:absolute before:top-1/2 before:left-full before:-translate-y-1/2 before:w-0 before:h-0 before:border-[6px] before:border-t-transparent before:border-b-transparent before:border-l-white dark:before:border-l-gray-800 before:border-r-transparent">
                                        <!-- View Button -->
                                        <a href="{{ route('requirement.detail', $requirement->id) }}" wire:navigate
                                            class="px-2 py-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors border-r dark:border-gray-700 cursor-pointer"
                                            title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <button type="button" wire:click="edit({{ $requirement->id }})"
                                            wire:loading.attr="disabled"
                                            class="px-2 py-1 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors border-r dark:border-gray-700 cursor-pointer"
                                            title="Edit">
                                            <i wire:loading.remove wire:target="edit({{ $requirement->id }})"
                                                class="fa-solid fa-pen-to-square"></i>
                                            <span wire:loading wire:target="edit({{ $requirement->id }})"
                                                class="ml-1">
                                                <i class="fa-solid fa-spinner animate-spin"></i>
                                            </span>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" wire:loading.attr="disabled"
                                            @click="confirmationModel = true; requirement_id = {{ $requirement->id }}"
                                            class="p-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                            title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
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
        <div class="mt-4">{{ $requirements->links() }}</div>
    </div>


    {{-- Delete Confirmation Modal --}}
    <div x-show="confirmationModel" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @keydown.escape.window="confirmationModel = false; requirement_id = null"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 dark:bg-gray-100/50"
        style="display: none;">
        <div
            class="flex flex-col items-center text-center bg-white dark:bg-gray-900 rounded-lg p-6 w-full max-w-md mx-auto shadow-lg">
            <div class="text-red-500 mb-2 text-3xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Requirement</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">Are you sure you want to delete this Requirement and
                its
                associated data?</p>
            <p class="text-sm text-gray-700 dark:text-gray-300">Remember! this action cannot be undone.</p>

            <div class="mt-6 space-x-3">
                <button type="button"
                    @click="$wire.delete(requirement_id); confirmationModel = false; requirement_id = null"
                    class="px-5 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500 focus:ring-2 focus:ring-red-400">
                    Delete
                </button>
                <button type="button" @click="confirmationModel = false; requirement_id = null"
                    class="px-5 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    {{-- Table Filter --}}
    <div x-show='filter_box' x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto p-4 flex items-start justify-center bg-gray-900/50 dark:bg-gray-100/50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-6xl max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white dark:bg-gray-800 px-8 py-4 border-b dark:border-gray-600 z-10">
                <h4 class="text-lg font-medium">Apply filters</h4>
            </div>
            <div class="px-8 py-4 grid lg:grid-cols-3 md:grid-cols-2 gap-4">
                {{-- Build ID --}}
                <x-single-select-box label='Build' model='build_id' live='true'>
                    <option value="all">All</option>
                    @forelse ($builds as $build)
                        <option class="overflow-ellipsis" wire:key='{{ $build->id }}'
                            value="{{ $build->id }}">{{ $build->name }}</option>
                    @empty
                    @endforelse
                </x-single-select-box>

                {{-- Module --}}
                <x-single-select-box label='Module' model='module_id' live='true'>
                    <option value="all">All</option>
                    @isset($modules)
                        @foreach ($modules as $module)
                            <option class="hover:text-white" wire:key='{{ $module->id }}'
                                value="{{ $module->id }}">{{ $module->module_name }}</option>
                        @endforeach
                    @endisset
                </x-single-select-box>

                {{-- Status --}}
                <x-single-select-box label='Status' model='status' live='true'>
                    <option value="all">All</option>
                    <option value="Backlog">Backlog</option>
                    <option value="Development">Development</option>
                    <option value="Testing">Testing</option>
                    <option value="Completed">Completed</option>
                    <option value="Ready for Testing">Ready for Testing</option>
                    <option value="Design">Design</option>
                    <option value="To Do">To Do</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Done">Done</option>
                </x-single-select-box>

                {{-- Created By --}}
                <x-single-select-box label='Created By' model='created_by' live='true'>
                    <option value="all">All</option>
                    @isset($created_by_users)
                        @foreach ($created_by_users as $user)
                            <option class="hover:text-white" wire:key='{{ $user->id }}'
                                value="{{ $user->id }}">{{ $user->username }}</option>
                        @endforeach
                    @endisset
                </x-single-select-box>
            </div>
            <div
                class="sticky bottom-0 bg-white dark:bg-gray-800 px-4 py-4 border-t dark:border-gray-600 flex items-center justify-center gap-4">
                <button wire:click='clearFilter'
                    class="px-4 py-2 rounded-md bg-red-500 text-gray-100 hover:bg-red-600 transition-colors text-sm">
                    Clear All
                </button>
                <button @click='filter_box = false'
                    class="px-4 py-2 rounded-md bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
