<div x-data="{
    filter_box: false,
    open_model: false,
    build_col: true,
    module_col: true,
    requirement_col: true,
    test_scenario_col: true,
    created_date_col: true,
}">

    <div class="flex items-center justify-between flex-wrap gap-4 px-8 py-4 border-b dark:border-gray-700">
        <div class="flex flex-col items-start">
            <a href="{{ route('test-cycles') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2">
                <i class="fa-solid fa-arrow-left"></i> Test Cycles
            </a>
            <h2 class="text-lg font-medium mt-2">Manage Test Cases in {{ $test_cycle->name }}</h2>
        </div>
        <div class="flex items-center gap-4 flex-wrap">
            <a href="{{ route('test-case-execution.list', $test_cycle->id) }}"
                class="flex items-center justify-center px-4 py-2 font-medium text-md bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-500 text-white rounded-md transition-colors duration-300"
                wire:navigate>
                <span><i class="fa-solid fa-play"></i> Execute Cycle</span>
            </a>
            <a href="{{ route('test-cycle.edit', $test_cycle->id) }}"
                class="flex items-center justify-center px-4 py-2 font-medium text-md bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md transition-colors duration-300"
                wire:navigate>
                <span><i class="fa-solid fa-pen-to-square"></i> Edit Cycle</span>
            </a>
        </div>
    </div>

    {{-- Assigned Test Cases --}}
    <div class="px-8 py-4 border-b dark:border-gray-700">
        <h3 class="text-lg font-medium mb-3">Assigned Test Cases</h3>
        {{-- Table Header --}}
        <div class="flex items-center justify-between flex-wrap gap-4">
            {{-- Items per page --}}
            <x-table-entries entries="assignedPerPage" />

            {{-- Search field --}}
            <x-search-field search='assignedSearch' placeholder='Search...' resetMethod='resetAssigendSearch' />
        </div>
        {{-- Table --}}
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <x-sortable-th name="tc_name" displayName="Test Case" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <th scope="col" class="px-4 py-3 text-left font-medium">Build</th>
                        <th scope="col" class="px-4 py-3 text-left font-medium">Module</th>
                        <th scope="col" class="px-4 py-3 text-left font-medium">Requirement</th>
                        <th scope="col" class="px-4 py-3 text-left font-medium">Test Scenario</th>
                        <th scope="col" class="px-4 py-3 font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($assigned_test_cases as $test_case)
                        <tr wire:key='{{ $test_case->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">
                                <a href="{{ route('test-case.detail', $test_case->id) }}"
                                    class="hover:text-blue-500 underline">
                                    {{ $test_case->tc_name }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                {{ $test_case->build->name ?? '' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $test_case->module->module_name ?? '' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $test_case->requirement->requirement_title ?? '' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $test_case->test_scenario->ts_name ?? '' }}
                            </td>
                            <td class="px-4 py-3 flex justify-center">
                                <button wire:loading.attr="disabled"
                                    @click="Swal.fire({
                                            title: 'Alert!',
                                            text: 'Are you sure you want to remove test case from this cycle.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Delete'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $wire.unassignTestCase({{ $test_case->id }})
                                            }
                                        })"
                                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors flex items-center gap-2 cursor-pointer">
                                    <span wire:loading.remove wire:target="unassignTestCase({{ $test_case->id }})">
                                        <i class="fa-solid fa-trash"></i> Remove
                                    </span>
                                    <span wire:loading wire:target="unassignTestCase({{ $test_case->id }})">
                                        <i class="fa-solid fa-spinner fa-spin"></i> Processing
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center p-4">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="mt-4">
            {{ $available_test_cases->links() }}
        </div>
    </div>
    {{-- Available Test Cases --}}
    <div class="px-8 py-4">
        <h3 class="text-lg font-medium">Available Test Cases</h3>
        <p class="mb-3">You see only approved test cases below. If you want to approve unapproved test cases first,
            then go to <a href="{{ route('test-cases') }}" class="hover:text-blue-500 underline" wire:navigate>Test Cases</a> - Edit status.</p>
        {{-- Table Header --}}
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
                                <label for="build_col" class="pl-4">Build</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="module_col" id="module_col" type="checkbox" class="dark:bg-gray-700"
                                    x-model="module_col">
                                <label for="module_col" class="pl-4">Module</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="requirement_col" id="requirement_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="requirement_col">
                                <label for="requirement_col" class="pl-4">Requirement</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="test_scenario_col" id="test_scenario_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="test_scenario_col">
                                <label for="test_scenario_col" class="pl-4">Test Scenario</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="created_date_col" id="created_date_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="created_date_col">
                                <label for="created_date_col" class="pl-4">Created Date</label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Filter Box Button --}}
                <button x-on:click='filter_box = !filter_box' type="button"
                    class="text-2xl text-gray-900 dark:text-gray-100"><i class="fa-solid fa-filter"></i>
                </button>
                {{-- Table Filter Model --}}
                <div x-show='filter_box' x-cloak
                    class="fixed inset-0 z-50 overflow-y-auto p-4 flex items-start justify-center bg-gray-900/50">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-6xl max-h-[90vh] overflow-y-auto">
                        <div
                            class="sticky top-0 bg-white dark:bg-gray-800 px-8 py-4 border-b dark:border-gray-600 z-10">
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

                            {{-- Requirements --}}
                            <x-single-select-box label='Requirement' model='requirement_id' live='true'>
                                <option value="all">All</option>
                                @isset($requirements)
                                    @foreach ($requirements as $requirement)
                                        <option class="hover:text-white" wire:key='{{ $requirement->id }}'
                                            value="{{ $requirement->id }}">{{ $requirement->requirement_title }}</option>
                                    @endforeach
                                @endisset
                            </x-single-select-box>

                            {{-- Test Scenario --}}
                            <x-single-select-box label='Test Scenario' model='test_scenario_id' live='true'>
                                <option value="all">All</option>
                                @isset($test_scenarios)
                                    @foreach ($test_scenarios as $test_scenario)
                                        <option class="hover:text-white" wire:key='{{ $test_scenario->id }}'
                                            value="{{ $test_scenario->id }}">{{ $test_scenario->ts_name }}</option>
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
        </div>
        {{-- Table --}}
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <x-sortable-th name="tc_name" displayName="Test Case" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <template x-if="build_col">
                            <th scope="col" class="px-4 py-3 text-left font-medium">Build</th>
                        </template>
                        <template x-if="module_col">
                            <th scope="col" class="px-4 py-3 text-left font-medium">Module</th>
                        </template>
                        <template x-if="requirement_col">
                            <th scope="col" class="px-4 py-3 text-left font-medium">Requirement</th>
                        </template>
                        <template x-if="test_scenario_col">
                            <th scope="col" class="px-4 py-3 text-left font-medium">Test Scenario
                            </th>
                        </template>
                        <template x-if="created_date_col">
                            <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <th scope="col" class="px-4 py-3 font-medium">Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($available_test_cases as $test_case)
                        <tr wire:key='{{ $test_case->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">
                                <a href="{{ route('test-case.detail', $test_case->id) }}"
                                    class="hover:text-blue-500 underline">
                                    {{ $test_case->tc_name }}
                                </a>
                            </td>
                            <template x-if="build_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->build->name ?? '' }}
                                </td>
                            </template>
                            <template x-if="module_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->module->module_name ?? '' }}
                                </td>
                            </template>
                            <template x-if="requirement_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->requirement->requirement_title ?? '' }}
                                </td>
                            </template>
                            <template x-if="test_scenario_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->test_scenario->ts_name ?? '' }}
                                </td>
                            </template>
                            <template x-if="created_date_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->created_at ? $test_case->created_at->format('d-m-Y') : '' }}
                                </td>
                            </template>
                            <td class="px-4 py-3 flex justify-center">
                                <button wire:loading.attr="disabled"
                                    wire:click="assignTestCase({{ $test_case->id }})"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors flex items-center gap-2 cursor-pointer">
                                    <span wire:loading.remove wire:target="assignTestCase({{ $test_case->id }})">
                                        <i class="fa-solid fa-copy"></i> Assign to Cycle
                                    </span>
                                    <span wire:loading wire:target="assignTestCase({{ $test_case->id }})"g>
                                        <i class="fa-solid fa-spinner fa-spin"></i> Processing
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center p-4">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="mt-4">
            {{ $available_test_cases->links() }}
        </div>
    </div>
</div>
