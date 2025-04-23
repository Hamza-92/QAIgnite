<div x-data="{
    filter_box: false,
    open_model: false,
    test_case_col: true,
    test_cycle_col: true,
    status_col: true,
    description_col: true,
    build_col: false,
    test_plan_col: false,
    test_scenario_col: false,
    execution_type_col: true,
    assigned_to_col: true,
    created_date_col: true,
}">

    <div class="flex items-center justify-between flex-wrap gap-4 px-8 py-4 border-b dark:border-gray-700">
        <div class="flex flex-col items-start">
            <a href="{{ route('test-cycles') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2">
                <i class="fa-solid fa-arrow-left"></i> Test Cycles
            </a>
            <h2 class="text-lg font-medium mt-2">Execute Test Cases in {{ $test_cycle->name }}</h2>
        </div>
        <a href="{{ route('test-cycle.assign_test_cases', $test_cycle->id) }}"
            class="flex items-center justify-center px-4 py-2 font-medium text-md bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md transition-colors duration-300"
            wire:navigate>
            <span><i class="fa-solid fa-plus"></i> Add Test Cases</span>
        </a>
    </div>
    <div class="px-8 py-6">
        <div class="border dark:border-gray-700 rounded-lg overflow-visible">
            <div class="flex flex-col md:flex-row">
                <!-- Stats Section -->
                <div class="flex-1 grid grid-cols-2 md:grid-cols-4 divide-x divide-y dark:divide-gray-700">
                    <!-- Total Test Cases -->
                    <div class="p-6 flex flex-col items-center justify-center">
                        <h3
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">
                            Total
                            Test Cases</h3>
                        <p class="mt-2 text-2xl font-semibold text-blue-600 dark:text-blue-400">{{ $total_test_cases }}
                        </p>
                    </div>

                    <!-- Passed -->
                    <div class="p-6 flex flex-col items-center justify-center">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Passed</h3>
                        <p class="mt-2 text-2xl font-semibold text-green-600 dark:text-green-400">
                            {{ $total_test_cases > 0 ? round(($passed_test_cases / $total_test_cases) * 100) . '%' : '0%' }}
                        </p>
                    </div>
                    <!-- Failed -->
                    <div class="p-6 flex flex-col items-center justify-center">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Failed</h3>
                        <p class="mt-2 text-2xl font-semibold text-red-600 dark:text-red-400">
                            {{ $total_test_cases > 0 ? round(($failed_test_cases / $total_test_cases) * 100) . '%' : '0%' }}
                        </p>
                    </div>
                    <!-- Not Executed -->
                    <div class="p-6 flex flex-col items-center justify-center">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">
                            Not Executed</h3>
                        <p class="mt-2 text-2xl font-semibold text-yellow-600 dark:text-yellow-400">
                            {{ $total_test_cases > 0 ? round(($not_executed_test_cases / $total_test_cases) * 100) . '%' : '0%' }}
                        </p>
                    </div>
                </div>

                <!-- Progress Bar Section -->
                <div class="flex-1 p-6 border-t md:border-t-0 md:border-l dark:border-gray-700">
                    <div class="h-full flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-4">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">All Statuses</p>
                            <!-- Info Icon + Tooltip -->
                            <div class="relative group">
                                <i
                                    class="fa-solid fa-circle-info text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer"></i>
                                <!-- Tooltip -->
                                <div
                                    class="absolute z-10 hidden group-hover:block left-full ml-2 p-3 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg border dark:border-gray-600">
                                    <div class="flex items-center mb-2">
                                        <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Passed</span>
                                    </div>
                                    <div class="flex items-center mb-2">
                                        <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Failed</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Not Executed</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Interactive Progress Bar -->
                        <div class="w-full h-6 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                            <div class="h-full flex">
                                <div class="bg-green-500 text-center text-white font-semibold"
                                    style="width: {{ $total_test_cases > 0 ? round(($passed_test_cases / $total_test_cases) * 100) : 0 }}%"
                                    title="Passed: {{ $passed_test_cases }}">
                                    {{ $passed_test_cases }}
                                </div>
                                <div class="bg-red-500 text-center text-white font-semibold"
                                    style="width: {{ $total_test_cases > 0 ? round(($failed_test_cases / $total_test_cases) * 100) : 0 }}%"
                                    title="Failed: {{ $failed_test_cases }}">
                                    {{ $failed_test_cases }}
                                </div>
                                <div class="bg-yellow-500 text-center text-white font-semibold"
                                    style="width: {{ $total_test_cases > 0 ? round(($not_executed_test_cases / $total_test_cases) * 100) : 0 }}%"
                                    title="Not Executed: {{ $not_executed_test_cases }}">
                                    {{ $not_executed_test_cases }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-8 py-4">
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
                                <input name="test_case_col" id="test_case_col" type="checkbox" class="dark:bg-gray-700"
                                    x-model="test_case_col">
                                <label for="test_case_col" class="pl-4 w-full">Test Case</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="test_cycle_col" id="test_cycle_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="test_cycle_col">
                                <label for="test_cycle_col" class="pl-4 w-full">Cycle</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="status_col" id="status_col" type="checkbox" class="dark:bg-gray-700"
                                    x-model="status_col">
                                <label for="status_col" class="pl-4 w-full">Status</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="description_col" id="description_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="description_col">
                                <label for="description_col" class="pl-4 w-full">Description</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="build_col" id="build_col" type="checkbox" class="dark:bg-gray-700"
                                    x-model="build_col">
                                <label for="build_col" class="pl-4 w-full">Build</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="test_plan_col" id="test_plan_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="test_plan_col">
                                <label for="test_plan_col" class="pl-4 w-full">Test Plan</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="test_scenario_col" id="test_scenario_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="test_scenario_col">
                                <label for="test_scenario_col" class="pl-4 w-full">Test Scenario</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="execution_type_col" id="execution_type_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="execution_type_col">
                                <label for="execution_type_col" class="pl-4 w-full">Execution Type</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="assigned_to_col" id="assigned_to_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="assigned_to_col">
                                <label for="assigned_to_col" class="pl-4 w-full">Assign To</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="created_date_col" id="created_date_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="created_date_col">
                                <label for="created_date_col" class="pl-4 w-full">Created Date</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter Box --}}
                <div>
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

                                {{-- Status --}}
                                <div class="flex flex-col gap-2">
                                    <label>Status</label>
                                    <div class="relative">
                                        <select wire:model.live='status' name="status" id="status"
                                            class="appearance-none px-4 pr-9 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                            <option value="all">All</option>
                                            <option value="Not Executed">Pending Approval</option>
                                            <option value="Passed">Approved</option>
                                            <option value="Failed">Rejected</option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                            <i @click="open_model = !open_model" wire:loading.remove
                                                wire:target='status' class="fa-solid fa-angle-down"></i>
                                            <i wire:loading wire:target='status'
                                                class="fa-solid fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- Execution Type --}}
                                <div class="flex flex-col gap-2">
                                    <label>Execution Type</label>
                                    <div class="relative">
                                        <select wire:model.live='execution_type' name="execution_type"
                                            id="execution_type"
                                            class="appearance-none px-4 pr-9 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                            <option value="all">All</option>
                                            <option value="cypress">Cypress</option>
                                            <option value="automated">Automated</option>
                                            <option value="manual">Manual</option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                            <i @click="open_model = !open_model" wire:loading.remove
                                                wire:target='execution_type' class="fa-solid fa-angle-down"></i>
                                            <i wire:loading wire:target='execution_type'
                                                class="fa-solid fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- Assigned To --}}
                                <div class="flex flex-col gap-2">
                                    <label>Assigned To</label>
                                    <div class="relative">
                                        <select wire:model.live='assigned_to' name="assigned_to" id="assigned_to"
                                            class="appearance-none px-4 pr-2 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                            <option value="all">All</option>
                                            @foreach ($assigned_to_users as $user)
                                                <option class="hover:text-white" wire:key='{{ $user->id }}'
                                                    value="{{ $user->id }}">{{ $user->username }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                            <i @click="open_model = !open_model" wire:loading.remove
                                                wire:target='assigned_to' class="fa-solid fa-angle-down"></i>
                                            <i wire:loading wire:target='assigned_to'
                                                class="fa-solid fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
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
        </div>

        {{-- Table --}}
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left font-medium">Execute</th>
                        <template x-if="test_case_col">
                            <x-sortable-th name="tc_name" displayName="Test Case" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="test_cycle_col">
                            <th scope="col" class="px-4 py-3 text-left font-medium">Cycle</th>
                        </template>
                        <template x-if="status_col">
                            <x-sortable-th name="tc_status" displayName="Status" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="status_col">
                            <x-sortable-th name="tc_description" displayName="Description" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="build_col">
                            <th scope="col" class="px-4 py-3 text-left font-medium">Build</th>
                        </template>
                        <template x-if="test_plan_col">
                            <th scope="col" class="px-4 py-3 text-left font-medium">Test Plan</th>
                        </template>
                        <template x-if="test_scenario_col">
                            <th scope="col" class="px-4 py-3 text-left font-medium">Test Scenario</th>
                        </template>
                        <template x-if="execution_type_col">
                            <th scope="col" class="px-4 py-3 text-left font-medium">Execution Type</th>
                        </template>
                        <template x-if="assigned_to_col">
                            <th scope="col" class="px-4 py-3 text-left font-medium">Assigned To</th>
                        </template>
                        <template x-if="created_date_col">
                            <x-sortable-th name="created_date" displayName="Created Date" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($test_cases as $test_case)
                        <tr wire:key='{{ $test_case->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">
                                <a class="px-3 py-1 rounded-md bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600"
                                    title="Execute Test Case" wire:navigate
                                    href="{{ route('test-case-execution.execute', [$test_cycle_id, $test_case->id]) }}">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </td>
                            <template x-if="test_case_col">
                                <td class="px-4 py-3">
                                    <a href="{{ route('test-case.detail', $test_case->id) }}" target="_blank"
                                        class="underline hover:text-blue-500">
                                        {{ $test_case->tc_name }}
                                    </a>
                                </td>
                            </template>
                            <template x-if="test_cycle_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->testCycles->first()->name ?? 'N/A' }}
                                </td>
                            </template>
                            <template x-if="status_col">
                                <td class="px-4 py-3">
                                    @php
                                        $statusClasses = [
                                            'Passed' =>
                                                'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200',
                                            'Failed' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200',
                                            'Not Executed' =>
                                                'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200',
                                        ];
                                    @endphp

                                    <span
                                        class="px-3 py-1 rounded-full {{ $statusClasses[$test_case->testCycles->first()->pivot->status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                        {{ $test_case->testCycles->first()->pivot->status }}
                                    </span>
                                </td>
                            </template>
                            <template x-if="description_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->tc_description ?? '' }}
                                </td>
                            </template>
                            <template x-if="build_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->build->name ?? '' }}
                                </td>
                            </template>
                            <template x-if="test_plan_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->testCycles->first()->testPlan->name ?? 'N/A' }}
                                </td>
                            </template>
                            <template x-if="test_scenario_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->test_scenario->ts_name ?? 'N/A' }}
                                </td>
                            </template>
                            <template x-if="execution_type_col">
                                <td class="px-4 py-3">
                                    {{ ucfirst($test_case->tc_execution_type) ?? '' }}
                                </td>
                            </template>
                            <template x-if="assigned_to_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->assigned_to->username ?? '' }}
                                </td>
                            </template>
                            <template x-if="created_date_col">
                                <td class="px-4 py-3">
                                    {{ $test_case->created_at ? $test_case->created_at->format('d-m-Y') : '' }}
                                </td>
                            </template>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="px-4 py-3 text-center">
                                No Record Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
