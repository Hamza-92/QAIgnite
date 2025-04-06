<div x-data="{
    filter_box: false,
    open_model: false,
    build_col: true,
    module_col: true,
    requirement_col: true,
    test_scenario_col: true,
    description_col: true,
    created_date_col: true
}">


    <div class="px-8 py-4">
        <div class="flex items-center justify-between flex-wrap gap-4">
            {{-- Items per page --}}
            <x-table-entries entries="perPage" />

            <div class="flex items-center gap-4">
                {{-- Search Field --}}
                <x-search-field search='search' placeholder='Search...' resetMethod='resetSearch' />

                <div x-data='{open_model:false}' @click.outside="open_model = false" @close.stop="open_model = false">
                    <button x-on:click='open_model = !open_model' type="button" title="Columns"
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
                                <input name="module_col" id="module_col" type="checkbox" class="dark:bg-gray-700"
                                    x-model="module_col">
                                <label for="module_col" class="pl-4 w-full">Module</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="requirement_col" id="requirement_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="requirement_col">
                                <label for="requirement_col" class="pl-4 w-full">Requirement</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="test_scenario_col" id="test_scenario_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="test_scenario_col">
                                <label for="test_scenario_col" class="pl-4 w-full">Test Scenario</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="description_col" id="description_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="description_col">
                                <label for="description_col" class="pl-4 w-full">Description</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="created_date_col" id="created_date_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="created_date_col">
                                <label for="created_date_col" class="pl-4 w-full">Created Date</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button x-on:click='filter_box = !filter_box' type="button"
                    class="text-2xl text-gray-900 dark:text-gray-100"><i class="fa-solid fa-filter"></i></button>
            </div>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <template x-if="build_col">
                            <x-sortable-th name="build.name" displayName="Build" :sortBy="$sortBy" :sortDir="$sortDir" />
                        </template>
                        <template x-if="module_col">
                            <x-sortable-th name="module_name" displayName="Module" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="requirement_col">
                            <x-sortable-th name="requirement_title" displayName="Requirement" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="test_scenario_col">
                            <x-sortable-th name="name" displayName="Test Scenario" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="description_col">
                            <x-sortable-th name="description" displayName="Description" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="created_date_col">
                            <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($test_scenarios as $test_scenario)
                        <tr wire:key='{{ $test_scenario->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <template x-if="build_col">
                                <td class="px-4 py-3">{{ $test_scenario->build->name ?? '' }}</td>
                            </template>
                            <template x-if="module_col">
                                <td class="px-4 py-3">{{ $test_scenario->module->module_name ?? '' }}</td>
                            </template>
                            <template x-if="requirement_col">
                                <td class="px-4 py-3">{{ $test_scenario->requirement->requirement_title ?? '' }}</td>
                            </template>
                            <template x-if="test_scenario_col">
                                <td class="px-4 py-3">{{ $test_scenario->ts_name }}</td>
                            </template>
                            <template x-if="description_col">
                                <td class="px-4 py-3" title="{{ $test_scenario->ts_description }}">
                                    {{ Str::limit($test_scenario->ts_description, 30, '...') }}
                                </td>
                            </template>
                            <template x-if="created_date_col">
                                <td class="px-4 py-3">{{ $test_scenario->created_at->format('d-m-Y') }}</td>
                            </template>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-1">
                                    <!-- View Button -->
                                    <a href="{{ route('test-scenario.detail', $test_scenario->id) }}" wire:navigate
                                        class="p-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                        title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <button type="button" wire:click="edit({{ $test_scenario->id }})"
                                        wire:loading.attr="disabled"
                                        class="p-1 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors cursor-pointer"
                                        title="Edit">
                                        <i wire:loading.remove wire:target="edit({{ $test_scenario->id }})"
                                            class="fa-solid fa-pen-to-square"></i>
                                        <span wire:loading wire:target="edit({{ $test_scenario->id }})"
                                            class="ml-1">
                                            <i class="fa-solid fa-spinner animate-spin"></i>
                                        </span>
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" wire:loading.attr="disabled"
                                        wire:target="delete({{ $test_scenario->id }})" x-data="{
                                            confirmDelete() {
                                                Swal.fire({
                                                    title: 'Are you sure?',
                                                    text: 'The test scenario will be permanently deleted!',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#3085d6',
                                                    confirmButtonText: 'Delete'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $wire.delete({{ $test_scenario->id }})
                                                    }
                                                })
                                            }
                                        }"
                                        @click="confirmDelete()"
                                        class="p-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                        title="Delete">
                                        <i wire:loading.remove wire:target="delete({{ $test_scenario->id }})"
                                            class="fa-solid fa-trash-can"></i>
                                        <span wire:loading wire:target="delete({{ $test_scenario->id }})"
                                            class="ml-1">
                                            <i class="fa-solid fa-spinner animate-spin"></i>
                                        </span>
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
        <div class="mt-4">{{ $test_scenarios->links() }}</div>
    </div>


    {{-- Table Models --}}
    {{-- Table column selector --}}
    <div x-show='columns'>
        <div>

        </div>
    </div>
    {{-- Table Filter --}}
    <div x-show='filter_box'
        class="absolute top-0 left-0 h-screen w-screen flex items-center justify-center bg-gray-900/50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="px-8 py-4 border-b dark:border-gray-600">
                <h4 class="text-lg">Apply filters</h4>
            </div>
            <div class="px-8 py-4 grid md:grid-cols-2 gap-4">
                {{-- Build ID --}}
                <div class="flex flex-col gap-2 w-full min-w-60 max-w-80">
                    <label>Build</label>
                    <div class="relative">
                        <select wire:model.live='build_id' wire:change='updateModulesList' name="build_id"
                            id="build_id"
                            class="appearance-none px-4 pr-9 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <option value="all">All</option>
                            @forelse ($builds as $build)
                                <option class="overflow-ellipsis" wire:key='{{ $build->id }}'
                                    value="{{ $build->id }}">{{ $build->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i @click="open_model = !open_model" wire:loading.remove wire:target='build_id'
                                class="fa-solid fa-angle-down"></i>
                            <i wire:loading wire:target='build_id' class="fa-solid fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>

                {{-- Module --}}
                <div class="flex flex-col gap-2">
                    <label>Module</label>
                    <div class="relative">
                        <select wire:model.live='module_id' name="module_id" id="module_id"
                            class="appearance-none px-4 pr-9 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <option value="all">All</option>
                            @isset($modules)
                                @foreach ($modules as $module)
                                    <option class="hover:text-white" wire:key='{{ $module->id }}'
                                        value="{{ $module->id }}">{{ $module->module_name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i @click="open_model = !open_model" wire:loading.remove wire:target='module_id'
                                class="fa-solid fa-angle-down"></i>
                            <i wire:loading wire:target='module_id' class="fa-solid fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="flex flex-col gap-2">
                    <label>Requirement</label>
                    <div class="relative">
                        <select wire:model.live='requirement_id' name="requirement_id" id="requirement_id"
                            class="appearance-none px-4 pr-9 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <option value="all">All</option>
                            @isset($requirements)
                                @foreach ($requirements as $requirement)
                                    <option class="hover:text-white" wire:key='{{ $requirement->id }}'
                                        value="{{ $requirement->id }}">{{ $requirement->requirement_title }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i @click="open_model = !open_model" wire:loading.remove wire:target='requirement_id'
                                class="fa-solid fa-angle-down"></i>
                            <i wire:loading wire:target='requirement_id' class="fa-solid fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>
                {{-- Created By --}}
                <div class="flex flex-col gap-2">
                    <label>Created By</label>
                    <div class="relative">
                        <select wire:model.live='created_by' name="created_by" id="created_by"
                            class="appearance-none px-4 pr-2 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <option value="">All</option>
                            @foreach ($users as $user)
                                <option class="hover:text-white" wire:key='{{ $user->id }}'
                                    value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i @click="open_model = !open_model" wire:loading.remove wire:target='created_by'
                                class="fa-solid fa-angle-down"></i>
                            <i wire:loading wire:target='created_by' class="fa-solid fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4 px-4 py-3">
                <button wire:click='clearFilter' class="px-4 py-2 rounded-md bg-red-500 text-gray-100">Clear
                    All</button>
                <button @click='filter_box = false'
                    class="px-4 py-2 rounded-md bg-gray-100 dark:bg-gray-700">Close</button>
            </div>
        </div>
    </div>
</div>
