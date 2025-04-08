<div x-data="{
    filter_box: false,
    open_model: false,
    tc_priority_col: true,
    tc_test_case_col: true,
    tc_status_col: true,
    tc_build_col: false,
    tc_module_col: false,
    tc_requirement_col: true,
    tc_test_scenario_col: true,
    tc_description_col: true,
    tc_assigned_to_col: false,
    tc_created_date_col: true,
    tc_execution_type_col: true
}">


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

                    <!-- Approved -->
                    <div class="p-6 flex flex-col items-center justify-center">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Approved</h3>
                        <p class="mt-2 text-2xl font-semibold text-green-600 dark:text-green-400">
                            {{ $total_test_cases > 0 ? round(($approved_test_cases / $total_test_cases) * 100) . '%' : '0%' }}
                        </p>
                    </div>

                    <!-- Pending -->
                    <div class="p-6 flex flex-col items-center justify-center">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Pending</h3>
                        <p class="mt-2 text-2xl font-semibold text-yellow-600 dark:text-yellow-400">
                            {{ $total_test_cases > 0 ? round(($pending_test_cases / $total_test_cases) * 100) . '%' : '0%' }}
                        </p>
                    </div>

                    <!-- Rejected -->
                    <div class="p-6 flex flex-col items-center justify-center">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Rejected</h3>
                        <p class="mt-2 text-2xl font-semibold text-red-600 dark:text-red-400">
                            {{ $total_test_cases > 0 ? round(($rejected_test_cases / $total_test_cases) * 100) . '%' : '0%' }}
                        </p>
                    </div>
                </div>

                <!-- Progress Bar Section -->
                <div
                    class="flex-1 p-6 border-t md:border-t-0 md:border-l dark:border-gray-700">
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
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Approved</span>
                                    </div>
                                    <div class="flex items-center mb-2">
                                        <span class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Pending</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Rejected</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Interactive Progress Bar -->
                        <div class="w-full h-6 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                            <div class="h-full flex">
                                <div class="bg-green-500 text-center text-white font-semibold"
                                    style="width: {{ $total_test_cases > 0 ? round(($approved_test_cases / $total_test_cases) * 100) : 0 }}%"
                                    title="Approved: {{ $approved_test_cases }}">
                                    {{ $approved_test_cases }}
                                </div>
                                <div class="bg-yellow-500 text-center text-white font-semibold"
                                    style="width: {{ $total_test_cases > 0 ? round(($pending_test_cases / $total_test_cases) * 100) : 0 }}%"
                                    title="Pending: {{ $pending_test_cases }}">
                                    {{ $pending_test_cases }}
                                </div>
                                <div class="bg-red-500 text-center text-white font-semibold"
                                    style="width: {{ $total_test_cases > 0 ? round(($rejected_test_cases / $total_test_cases) * 100) : 0 }}%"
                                    title="Rejected: {{ $rejected_test_cases }}">
                                    {{ $rejected_test_cases }}
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
                                <input name="tc_priority_col" id="tc_priority_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="tc_priority_col">
                                <label for="tc_priority_col" class="pl-4">Priority</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="tc_test_case_col" id="tc_test_case_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="tc_test_case_col">
                                <label for="tc_test_case_col" class="pl-4">Test Case</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="tc_status_col" id="tc_status_col" type="checkbox" class="dark:bg-gray-700"
                                    x-model="tc_status_col">
                                <label for="tc_status_col" class="pl-4">Status</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="tc_build_col" id="tc_build_col" type="checkbox" class="dark:bg-gray-700"
                                    x-model="tc_build_col">
                                <label for="tc_build_col" class="pl-4">Build</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="tc_module_col" id="tc_module_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="tc_module_col">
                                <label for="tc_module_col" class="pl-4">Module</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="tc_requirement_col" id="tc_requirement_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="tc_requirement_col">
                                <label for="tc_requirement_col" class="pl-4">Requirement</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="tc_test_scenario_col" id="tc_test_scenario_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="tc_test_scenario_col">
                                <label for="tc_test_scenario_col" class="pl-4">Test Scenario</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="tc_description_col" id="tc_description_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="tc_description_col">
                                <label for="tc_description_col" class="pl-4">Description</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="tc_assigned_to_col" id="tc_assigned_to_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="tc_assigned_to_col">
                                <label for="tc_assigned_to_col" class="pl-4">Assigned To</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="tc_created_date_col" id="tc_created_date_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="tc_created_date_col">
                                <label for="tc_created_date_col" class="pl-4">Created Date</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="tc_execution_type_col" id="tc_execution_type_col" type="checkbox"
                                    class="dark:bg-gray-600" x-model="tc_execution_type_col">
                                <label for="tc_execution_type_col" class="pl-4">Execution Type</label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Filter Box Button --}}
                <button x-on:click='filter_box = !filter_box' type="button"
                    class="text-2xl text-gray-900 dark:text-gray-100"><i class="fa-solid fa-filter"></i></button>
            </div>
        </div>

        {{-- Table --}}
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <template x-if="tc_priority_col">
                            <x-sortable-th name="tc_priority" displayName="Priority" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="tc_test_case_col">
                            <x-sortable-th name="tc_name" displayName="Test Case" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="tc_status_col">
                            <x-sortable-th name="tc_status" displayName="Status" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="tc_build_col">
                            <x-sortable-th name="tc_build_id" displayName="Build" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="tc_module_col">
                            <x-sortable-th name="tc_module_id" displayName="Module" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="tc_requirement_col">
                            <x-sortable-th name="tc_requirement_id" displayName="Requirement" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="tc_test_scenario_col">
                            <x-sortable-th name="tc_test_scenario_id" displayName="Test Scenario" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="tc_description_col">
                            <x-sortable-th name="tc_description" displayName="Description" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="tc_assigned_to_col">
                            <x-sortable-th name="assigned_to->username" displayName="Assigned To" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="tc_created_date_col">
                            <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="tc_execution_type_col">
                            <x-sortable-th name="tc_execution_type" displayName="Execution Type" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($test_cases as $test_case)
                        <tr wire:key='{{ $test_case->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <template x-if="tc_priority_col">
                                <td class="px-4 py-3">
                                    @if ($test_case->tc_priority === 'low')
                                        <span class="flex items-center">
                                            <span class="w-2 h-2 rounded-full bg-gray-500 mr-2"></span>
                                            Low
                                        </span>
                                    @elseif ($test_case->tc_priority === 'medium')
                                        <span class="flex items-center">
                                            <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                                            Medium
                                        </span>
                                    @elseif ($test_case->tc_priority === 'high')
                                        <span class="flex items-center">
                                            <span class="text-red-500 mr-2"><i
                                                    class="fa-solid fa-arrow-up"></i></span>
                                            High
                                        </span>
                                    @else
                                        {{ $test_case->tc_priority ?? '' }}
                                    @endif
                                </td>
                            </template>
                            <template x-if="tc_test_case_col">
                                <td class="px-4 py-3">{{ $test_case->tc_name }}</td>
                            </template>
                            <template x-if="tc_status_col">
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded
                                        {{ match ($test_case->tc_status) {
                                            'pending' => 'bg-yellow-500 text-white dark:bg-yellow-600',
                                            'approved' => 'bg-green-500 text-white dark:bg-green-600',
                                            'rejected' => 'bg-red-500 text-white dark:bg-red-600',
                                            default => 'bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                        } }}">
                                        {{ ucfirst($test_case->tc_status) }}
                                    </span>
                                </td>
                            </template>
                            <template x-if="tc_build_col">
                                <td class="px-4 py-3">{{ $test_case->build->name ?? '' }}</td>
                            </template>
                            <template x-if="tc_module_col">
                                <td class="px-4 py-3">{{ $test_case->module->module_name ?? '' }}</td>
                            </template>
                            <template x-if="tc_requirement_col">
                                <td class="px-4 py-3">
                                    <a href="{{ route('requirement.detail', $test_case->requirement->id ?? '') }}"
                                        class="hover:text-blue-500 underline" wire:navigate>
                                        <span title="{{ $test_case->requirement->requirement_title ?? '' }}">
                                            {{ Str::limit($test_case->requirement->requirement_title ?? '', 30, '...') }}
                                        </span>
                                    </a>
                                </td>
                            </template>
                            <template x-if="tc_test_scenario_col">
                                <td class="px-4 py-3">
                                    <a href="{{ route('test-scenario.detail', $test_case->test_scenario->id ?? '') }}"
                                        class="hover:text-blue-500 underline" wire:navigate>
                                        <span title="{{ $test_case->test_scenario->ts_name ?? '' }}">
                                            {{ Str::limit($test_case->test_scenario->ts_name ?? '', 30, '...') }}
                                        </span>
                                    </a>
                                </td>
                            </template>
                            <template x-if="tc_description_col">
                                <td class="px-4 py-3">
                                    <span title="{{ $test_case->tc_description ?? '' }}">
                                        {{ Str::limit($test_case->tc_description ?? '', 50, '...') }}
                                    </span>
                                </td>
                            </template>
                            <template x-if="tc_assigned_to_col">
                                <td class="px-4 py-3">{{ $test_case->assigned_to->username ?? '' }}</td>
                            </template>
                            <template x-if="tc_created_date_col">
                                <td class="px-4 py-3">{{ $test_case->created_at->format('Y-m-d') ?? '' }}</td>
                            </template>
                            <template x-if="tc_execution_type_col">
                                <td class="px-4 py-3">{{ $test_case->tc_execution_type ?? '' }}</td>
                            </template>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative" x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="px-4 py-1 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 cursor-pointer">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-transition
                                        class="absolute top-1/2 right-full mr-3 transform -translate-y-1/2 p-1 text-md bg-white dark:bg-gray-800 rounded-md border dark:border-gray-700 shadow-lg z-10 flex items-center justify-center gap-2 before:absolute before:top-1/2 before:left-full before:-translate-y-1/2 before:w-0 before:h-0 before:border-[6px] before:border-t-transparent before:border-b-transparent before:border-l-white dark:before:border-l-gray-800 before:border-r-transparent">
                                        <!-- View Button -->
                                        <a href="{{ route('test-case.detail', $test_case->id) }}" wire:navigate
                                            class="px-2 py-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors border-r dark:border-gray-700 cursor-pointer"
                                            title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <button type="button" wire:click="editTestCase({{ $test_case->id }})"
                                            wire:loading.attr="disabled"
                                            class="px-2 py-1 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors border-r dark:border-gray-700 cursor-pointer"
                                            title="Edit Test Case">
                                            <i wire:loading.remove wire:target="editTestCase({{ $test_case->id }})"
                                                class="fa-solid fa-pen-to-square"></i>
                                            <span wire:loading wire:target="editTestCase({{ $test_case->id }})"
                                                class="ml-1">
                                                <i class="fa-solid fa-spinner animate-spin"></i>
                                            </span>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" wire:loading.attr="disabled"
                                            wire:target="deleteTestCase({{ $test_case->id }})"
                                            @click="Swal.fire({
                                                title: 'Are you sure?',
                                                text: 'The test case will be permanently deleted!',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Delete'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $wire.deleteTestCase({{ $test_case->id }})
                                                }
                                            })"
                                            class="px-2 py-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                            title="Delete">
                                            <i wire:loading.remove wire:target="deleteTestCase({{ $test_case->id }})"
                                                class="fa-solid fa-trash-can"></i>
                                            <span wire:loading wire:target="deleteTestCase({{ $test_case->id }})"
                                                class="ml-1">
                                                <i class="fa-solid fa-spinner animate-spin"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full p-4 text-center" colspan="8">No Records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="mt-4">
                {{ $test_cases->links() }}
        </div>
    </div>


    {{-- Table Filter Model --}}
    <div x-show='filter_box' x-cloak
    class="fixed inset-0 z-50 overflow-y-auto p-4 flex items-start justify-center bg-gray-900/50">
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

                {{-- Status --}}
                <div class="flex flex-col gap-2">
                    <label>Status</label>
                    <div class="relative">
                        <select wire:model.live='status' name="status" id="status"
                            class="appearance-none px-4 pr-9 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <option value="all">All</option>
                            <option value="pending">Pending Approval</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i @click="open_model = !open_model" wire:loading.remove wire:target='status'
                                class="fa-solid fa-angle-down"></i>
                            <i wire:loading wire:target='status' class="fa-solid fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>
                {{-- Testing Type --}}
                <div class="flex flex-col gap-2">
                    <label>Testing Type</label>
                    <div class="relative">
                        <select wire:model.live='testing_type' name="testing_type" id="testing_type"
                            class="appearance-none px-4 pr-9 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <option value="all">All</option>
                            <option value="field-validation">Field Validation</option>
                            <option value="content">Content</option>
                            <option value="cross-browser/os">Cross Browser/OS</option>
                            <option value="ui/ux">UI/UX</option>
                            <option value="security">Security</option>
                            <option value="performance">Performance</option>
                            <option value="functional">Functional</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i @click="open_model = !open_model" wire:loading.remove wire:target='testing_type'
                                class="fa-solid fa-angle-down"></i>
                            <i wire:loading wire:target='testing_type' class="fa-solid fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>
                {{-- Execution Type --}}
                <div class="flex flex-col gap-2">
                    <label>Execution Type</label>
                    <div class="relative">
                        <select wire:model.live='execution_type' name="execution_type" id="execution_type"
                            class="appearance-none px-4 pr-9 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <option value="all">All</option>
                            <option value="cypress">Cypress</option>
                            <option value="automated">Automated</option>
                            <option value="manual">Manual</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i @click="open_model = !open_model" wire:loading.remove wire:target='execution_type'
                                class="fa-solid fa-angle-down"></i>
                            <i wire:loading wire:target='execution_type' class="fa-solid fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>
                {{-- Created By --}}
                <div class="flex flex-col gap-2">
                    <label>Created By</label>
                    <div class="relative">
                        <select wire:model.live='created_by' name="created_by" id="created_by"
                            class="appearance-none px-4 pr-2 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <option value="all">All</option>
                            @foreach ($created_by_users as $user)
                                <option class="hover:text-white" wire:key='{{ $user->id }}'
                                    value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i @click="open_model = !open_model" wire:loading.remove wire:target='created_by'
                                class="fa-solid fa-angle-down"></i>
                            <i wire:loading wire:target='created_by' class="fa-solid fa-spinner fa-spin"></i>
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
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i @click="open_model = !open_model" wire:loading.remove wire:target='assigned_to'
                                class="fa-solid fa-angle-down"></i>
                            <i wire:loading wire:target='assigned_to' class="fa-solid fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>
                {{-- Approval Request --}}
                <div class="flex flex-col gap-2">
                    <label>Approval Request</label>
                    <div class="relative">
                        <select wire:model.live='approval_requested' name="approval_requested"
                            id="approval_requested"
                            class="appearance-none px-4 pr-2 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <option value="all">All</option>
                            @foreach ($approval_requested_users as $user)
                                <option class="hover:text-white" wire:key='{{ $user->id }}'
                                    value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i @click="open_model = !open_model" wire:loading.remove wire:target='approval_requested'
                                class="fa-solid fa-angle-down"></i>
                            <i wire:loading wire:target='approval_requested' class="fa-solid fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sticky bottom-0 bg-white dark:bg-gray-800 px-4 py-4 border-t dark:border-gray-600 flex items-center justify-center gap-4">
                <button wire:click='clearFilter' class="px-4 py-2 rounded-md bg-red-500 text-gray-100 hover:bg-red-600 transition-colors text-sm">
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
