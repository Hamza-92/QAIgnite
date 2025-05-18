<div x-data="{
    filter_box: false,
    open_model: false,
    confirmationModel: false,
    defect_id: null,
    defect_name_col: true,
    defect_description_col: true,
    defect_test_case_col: true,
    defect_severity_col: true,
    defect_type_col: true,
    defect_status_col: true,
    defect_priority_col: false,
    defect_assigned_to_col: false,
    defect_created_date_col: true,
    defect_modified_date_col: false,
}">

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
                                <input name="defect_name_col" id="defect_name_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="defect_name_col">
                                <label for="defect_name_col" class="pl-4 w-full">Defect</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="defect_description_col" id="defect_description_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="defect_description_col">
                                <label for="defect_description_col" class="pl-4 w-full">Description</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="defect_test_case_col" id="defect_test_case_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="defect_test_case_col">
                                <label for="defect_test_case_col" class="pl-4 w-full">Test Case</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="defect_severity_col" id="defect_severity_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="defect_severity_col">
                                <label for="defect_severity_col" class="pl-4 w-full">Severity</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="defect_type_col" id="defect_type_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="defect_type_col">
                                <label for="defect_type_col" class="pl-4 w-full">Defect Type</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="defect_status_col" id="defect_status_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="defect_status_col">
                                <label for="defect_status_col" class="pl-4 w-full">Status</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="defect_priority_col" id="defect_priority_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="defect_priority_col">
                                <label for="defect_priority_col" class="pl-4 w-full">Priorty</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="defect_assigned_to_col" id="defect_assigned_to_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="defect_assigned_to_col">
                                <label for="defect_assigned_to_col" class="pl-4 w-full">Assigned To</label>
                            </div>
                            <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                <input name="defect_created_date_col" id="defect_created_date_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="defect_created_date_col">
                                <label for="defect_created_date_col" class="pl-4 w-full">Created Date</label>
                            </div>
                            <div class="flex items-center px-4 py-3">
                                <input name="defect_modified_date_col" id="defect_modified_date_col" type="checkbox"
                                    class="dark:bg-gray-700" x-model="defect_modified_date_col">
                                <label for="defect_modified_date_col" class="pl-4 w-full">Modified Date</label>
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
                        <template x-if="defect_name_col">
                            <x-sortable-th name="def_name" displayName="Defect" :sortBy="$sortBy" :sortDir="$sortDir" />
                        </template>
                        <template x-if="defect_description_col">
                            <x-sortable-th name="def_description" displayName="Description" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="defect_test_case_col">
                            <x-sortable-th name="def_test_case" displayName="Test Case" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="defect_severity_col">
                            <x-sortable-th name="def_severity" displayName="Severity" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="defect_status_col">
                            <x-sortable-th name="def_status" displayName="Status" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="defect_type_col">
                            <x-sortable-th name="def_type" displayName="Defect Type" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="defect_priority_col">
                            <x-sortable-th name="def_priority" displayName="Priority" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="defect_assigned_to_col">
                            <x-sortable-th name="def_assigned_to" displayName="Assigned To" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="defect_created_date_col">
                            <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <template x-if="defect_modified_date_col">
                            <x-sortable-th name="modified_at" displayName="Modified Date" :sortBy="$sortBy"
                                :sortDir="$sortDir" />
                        </template>
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($defects as $defect)
                        <tr wire:key='{{ $defect->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <template x-if="defect_name_col">
                                <td class="px-4 py-3">
                                    <a class="underline hover:text-blue-500"
                                        href="{{ route('defect.detail', $defect->id) }}" wire:navigate>
                                        {{ $defect->def_name }}
                                    </a>
                                </td>
                            </template>
                            <template x-if="defect_description_col">
                                <td class="px-4 py-3">
                                    <span title="{{ $defect->def_description ?? '' }}">
                                        {{ Str::limit($defect->def_description ?? '', 30, '...') }}
                                    </span>
                                </td>
                            </template>
                            <template x-if="defect_test_case_col">
                                <td class="px-4 py-3">
                                    <a class="underline hover:text-blue-500"
                                        href="{{ route('test-case.detail', $defect->def_test_case_id ?? '') }}"
                                        wire:navigate>
                                        {{ $defect->testCase->tc_name ?? '' }}
                                    </a>
                                </td>
                            </template>
                            <template x-if="defect_severity_col">
                                <td class="px-4 py-3">
                                    @if ($defect->def_severity === 'minor')
                                        <span class="flex items-center">
                                            <span class="w-3 h-3 rounded-full bg-gray-500 mr-2"></span>
                                            Minor
                                        </span>
                                    @elseif ($defect->def_severity === 'major')
                                        <span class="flex items-center">
                                            <span class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                                            Major
                                        </span>
                                    @elseif ($defect->def_severity === 'blocker')
                                        <span class="flex items-center">
                                            <span class="text-red-500 mr-2"><i
                                                    class="fa-solid fa-arrow-up"></i></span>
                                            Blocker
                                        </span>
                                    @else
                                        {{ $defect->def_severity ?? '' }}
                                    @endif
                                </td>
                            </template>
                            <template x-if="defect_status_col">
                                <td class="px-4 py-3">{{ $defect->def_status ?? '' }}</td>
                            </template>
                            <template x-if="defect_type_col">
                                <td class="px-4 py-3">{{ $defect->def_type ?? '' }}</td>
                            </template>
                            <template x-if="defect_priority_col">
                                <td class="px-4 py-3">{{ $defect->def_priority ?? '' }}</td>
                            </template>
                            <template x-if="defect_assigned_to_col">
                                <td class="px-4 py-3">{{ $defect->assignedTo->username ?? '' }}</td>
                            </template>
                            <template x-if="defect_created_date_col">
                                <td class="px-4 py-3">{{ $defect->created_at->format('M j, Y g:i A') }}</td>
                            </template>
                            <template x-if="defect_modified_date_col">
                                <td class="px-4 py-3">{{ $defect->updated_at->format('M j, Y g:i A') }}</td>
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
                                        <a href="{{ route('defect.detail', $defect->id) }}" wire:navigate
                                            class="px-2 py-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors border-r dark:border-gray-700 cursor-pointer"
                                            title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <button type="button" wire:click="editDefect({{ $defect->id }})"
                                            wire:loading.attr="disabled"
                                            class="px-2 py-1 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors border-r dark:border-gray-700 cursor-pointer"
                                            title="Edit Test Case">
                                            <i wire:loading.remove wire:target="editDefect({{ $defect->id }})"
                                                class="fa-solid fa-pen-to-square"></i>
                                            <span wire:loading wire:target="editDefect({{ $defect->id }})"
                                                class="ml-1">
                                                <i class="fa-solid fa-spinner animate-spin"></i>
                                            </span>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" wire:loading.attr="disabled"
                                            @click="confirmationModel = true; defect_id = {{ $defect->id }}"
                                            class="p-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors cursor-pointer"
                                            title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="px-4 py-3 text-center text-gray-500">
                                No records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="mt-4">
            {{ $defects->links() }}
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div x-show="confirmationModel" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @keydown.escape.window="confirmationModel = false; test_scenario_id = null"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 dark:bg-gray-100/50"
        style="display: none;">
        <div
            class="flex flex-col items-center text-center bg-white dark:bg-gray-900 rounded-lg p-6 w-full max-w-md mx-auto shadow-lg">
            <div class="text-red-500 mb-2 text-3xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Defect</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">Are you sure you want to delete this defect?
            </p>
            <p class="text-sm text-gray-700 dark:text-gray-300">Remember! this action cannot be undone.</p>

            <div class="mt-6 space-x-3">
                <button type="button"
                    @click="$wire.deleteDefect(defect_id); confirmationModel = false; defect_id = null"
                    class="px-5 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500 focus:ring-2 focus:ring-red-400">
                    Delete
                </button>
                <button type="button" @click="confirmationModel = false; defect_id = null"
                    class="px-5 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">
                    Cancel
                </button>
            </div>
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
                            <option class="overflow-ellipsis" wire:key='{{ $module->id }}'
                                value="{{ $module->id }}">{{ $module->module_name }}</option>
                        @endforeach
                    @endisset
                </x-single-select-box>

                {{-- Requirements --}}
                <x-single-select-box label='Requirement' model='requirement_id' live='true'>
                    <option value="all">All</option>
                    @isset($requirements)
                        @foreach ($requirements as $requirement)
                            <option class="overflow-ellipsis" wire:key='{{ $requirement->id }}'
                                value="{{ $requirement->id }}">{{ $requirement->requirement_title }}</option>
                        @endforeach
                    @endisset
                </x-single-select-box>

                {{-- Test Scenario --}}
                <x-single-select-box label='Test Scenario' model='test_scenario_id' live='true'>
                    <option value="all">All</option>
                    @isset($test_scenarios)
                        @foreach ($test_scenarios as $test_scenario)
                            <option class="overflow-ellipsis" wire:key='{{ $test_scenario->id }}'
                                value="{{ $test_scenario->id }}">{{ $test_scenario->ts_name }}</option>
                        @endforeach
                    @endisset
                </x-single-select-box>

                {{-- Test Case --}}
                <x-single-select-box label='Test Case' model='test_case_id' live='true'>
                    <option value="all">All</option>
                    @isset($test_cases)
                        @foreach ($test_cases as $test_case)
                            <option class="overflow-ellipsis" wire:key='{{ $test_case->id }}'
                                value="{{ $test_case->id }}">{{ $test_case->tc_name }}</option>
                        @endforeach
                    @endisset
                </x-single-select-box>

                {{-- Defect Type --}}
                <x-single-select-box label='Defect Type' model='defect_type' live='true'>
                    <option value="all">All</option>
                    <option value="functional">Functional</option>
                    <option value="ui/ux">UI/UX</option>
                    <option value="cross-browser">Cross-Browser</option>
                    <option value="cross-platform">Cross-Platform</option>
                    <option value="field-validation">Field Validation</option>
                    <option value="performance">Performance</option>
                    <option value="security">Security</option>
                    <option value="usability">Usability</option>
                    <option value="compatibility">Compatibility</option>
                    <option value="integration">Integration</option>
                </x-single-select-box>

                {{-- Defect Status --}}
                <x-single-select-box label='Defect Status' model='defect_status' live='true'>
                    <option value="all">All</option>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                    <option value="fixed">Fixed</option>
                    <option value="re-open">Re-Open</option>
                    <option value="not-a-bug">Not a Bug</option>
                    <option value="resolved">Resolved</option>
                    <option value="deffer">Deffer</option>
                    <option value="too-limitations">Too Limitations</option>
                    <option value="not-reproducible">Not Reproducible</option>
                    <option value="user-interface">User Interface</option>
                    <option value="beta">Beta</option>
                    <option value="in-progress">In Progress</option>
                    <option value="to-do">To Do</option>
                    <option value="in-review">In Review</option>
                </x-single-select-box>

                {{-- Defect Priority --}}
                <x-single-select-box label='Defect Priority' model='defect_priority' live='true'>
                    <option value="all">All</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </x-single-select-box>

                {{-- Defect Severity --}}
                <x-single-select-box label='Defect Severity' model='defect_severity' live='true'>
                    <option value="all">All</option>
                    <option value="blocker">Blocker</option>
                    <option value="major">Major</option>
                    <option value="minor">Minor</option>
                </x-single-select-box>

                {{-- Defect Environment --}}
                <x-single-select-box label='Defect Environment' model='defect_environment' live='true'>
                    <option value="all">All</option>
                    <option value="production">Production</option>
                    <option value="staging">Staging</option>
                    <option value="development">Development</option>
                    <option value="testing">Testing</option>
                    <option value="qa">QA</option>
                </x-single-select-box>

                {{-- Created By --}}
                <x-single-select-box label='Created By' model='created_by' live='true'>
                    <option value="all">All</option>
                    @forelse ($created_by_users as $user)
                        <option wire:key='{{ $user->id }}' value="{{ $user->id }}">{{ $user->username }}
                        </option>
                    @empty
                    @endforelse
                </x-single-select-box>

                {{-- Assigned To --}}
                <x-single-select-box label='Assigned To' model='assigned_to' live='true'>
                    <option value="all">All</option>
                    @forelse ($assigned_to_users as $user)
                        <option wire:key='{{ $user->id }}' value="{{ $user->id }}">{{ $user->username }}
                        </option>
                    @empty
                    @endforelse
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
