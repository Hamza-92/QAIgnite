<div>
    <div class="px-8 pt-2 w-full flex items-end gap-1 border-b dark:border-gray-700 transition-colors duration-200">
        <a href="{{ route('reports.defect-report') }}" wire:navigate class="p-2 border-b-2 border-blue-500">Defect Report</a>
        <a href="{{ route('reports.test-case-report') }}" wire:navigate class="p-2 hover:border-b-2 border-blue-500">Test Case Report</a>
    </div>
    <div
        class="px-8 py-4 flex items-center flex-wrap gap-4 justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg">Defect Report</h2>
    </div>

    {{-- Report Filter --}}
    <div class="px-8 py-4">
        <div x-data="{ open_model: true }" class="w-full">
            <div @click="open_model = !open_model"
                class="w-full flex items-center justify-between px-4 py-2 cursor-pointer text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300 rounded-t-md"
                :class="{ 'rounded-md': !open_model }">
                <h3 class="text-lg font-medium">Defect Report Filter</h3>
                <span class="px-2 py-1 bg-white text-gray-900 font-bold rounded transition-transform duration-300"
                    :class="{ 'rotate-180': open_model }" x-text="open_model ? '−' : '+'"></span>
            </div>

            <div x-show="open_model" x-collapse.duration.300ms
                class="p-6 grid md:grid-cols-2 gap-6 overflow-hidden border dark:border-gray-700">
                <div class="grid sm:grid-cols-2 gap-2">
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
                            <option wire:key='{{ $user->id }}' value="{{ $user->id }}">
                                {{ $user->username }}
                            </option>
                        @empty
                        @endforelse
                    </x-single-select-box>

                    {{-- Assigned To --}}
                    <x-single-select-box label='Assigned To' model='assigned_to' live='true'>
                        <option value="all">All</option>
                        @forelse ($assigned_to_users as $user)
                            <option wire:key='{{ $user->id }}' value="{{ $user->id }}">
                                {{ $user->username }}
                            </option>
                        @empty
                        @endforelse
                    </x-single-select-box>
                </div>

                {{-- Extended Search --}}
                <div class="space-y-4">
                    <h3 class="text-lg text-blue-500 mb-2">Extended Search</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 items-start">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_name" value="def_name" disabled
                                wire:model='reportColumns'>
                            <label for="def_name">Defect ID</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_description" value="def_description"
                                wire:model='reportColumns'>
                            <label for="def_description">Description</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_status" value="def_status" wire:model='reportColumns'>
                            <label for="def_status">Status</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_type" value="def_type" wire:model='reportColumns'>
                            <label for="def_type">Type</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_priority" value="def_priority"
                                wire:model='reportColumns'>
                            <label for="def_priority">Priority</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_severity" value="def_severity"
                                wire:model='reportColumns'>
                            <label for="def_severity">Severity</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_environment" value="def_environment"
                                wire:model='reportColumns'>
                            <label for="def_environment">Environment</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_steps_to_reproduce" value="def_steps_to_reproduce"
                                wire:model='reportColumns'>
                            <label for="def_steps_to_reproduce">Steps to Reproduce</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_expected_result" value="def_expected_result"
                                wire:model='reportColumns'>
                            <label for="def_expected_result">Expected Result</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_actual_result" value="def_actual_result"
                                wire:model='reportColumns'>
                            <label for="def_actual_result">Actual Result</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_requirement_id" value="def_requirement_id"
                                wire:model='reportColumns'>
                            <label for="def_requirement_id">Requirement</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="def_assigned_to" value="def_assigned_to"
                                wire:model='reportColumns'>
                            <label for="def_assigned_to">Assigned To</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="created_at" value="created_at" wire:model='reportColumns'>
                            <label for="created_at">Created Date</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="updated_at" value="updated_at" wire:model='reportColumns'>
                            <label for="updated_at">Closure Date</label>
                        </div>
                    </div>
                    <button wire:click='generateReport' @click='open_model = false' class="px-4 py-2 bg-blue-500 text-white rounded-md">Generate
                        Report</button>
                </div>
            </div>
        </div>
    </div>

    @if (isset($defects))
        <div class="px-8 py-6 mt-8">
            <div class="w-full flex items-end justify-between gap-4 flex-wrap">
                <x-table-entries entries="perPage" />
                <div class="px-4 py-2 flex flex-col gap-2 justify-start bg-gray-100 dark:bg-gray-800 rounded-md">
                    <p class="text-blue-500 dark:text-blue-400">Export As</p>
                    <div class="flex gap-4 flex-wrap">
                        <button wire:click='downloadDocReport' class="text-blue-500 text-5xl cursor-pointer" title="Export as DOC">
                            <i class="fas fa-file-word"></i>
                        </button>
                        <button wire:click='downloadExcelReport' class="text-green-500 text-5xl cursor-pointer" title="Export as Excel">
                            <i class="fas fa-file-excel"></i>
                        </button>
                        <button wire:click='downloadCsvReport' class="text-orange-500 text-5xl cursor-pointer" title="Export as CSV">
                            <i class="fas fa-file-csv"></i>
                        </button>
                        <button wire:click='downloadPdfReport' class="text-red-500 text-5xl cursor-pointer" title="Export as PDF">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-auto">
                <table class="w-full border-collapse text-sm">
                    <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                        <tr>
                            @if ($reportColumns && in_array('def_name', $reportColumns))
                                <x-sortable-th name="def_name" displayName="Defect" :sortBy="$sortBy"
                                    :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('def_severity', $reportColumns))
                                <x-sortable-th name="def_severity" displayName="Severity" :sortBy="$sortBy"
                                    :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('def_description', $reportColumns))
                                <x-sortable-th name="def_description" displayName="Description" :sortBy="$sortBy"
                                    :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('def_status', $reportColumns))
                                <x-sortable-th name="def_status" displayName="Status" :sortBy="$sortBy"
                                    :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('def_type', $reportColumns))
                                <x-sortable-th name="def_type" displayName="Type" :sortBy="$sortBy"
                                    :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('def_priority', $reportColumns))
                                <x-sortable-th name="def_priority" displayName="Priority" :sortBy="$sortBy"
                                    :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('def_environment', $reportColumns))
                                <x-sortable-th name="def_environment" displayName="Environment" :sortBy="$sortBy"
                                    :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('def_steps_to_reproduce', $reportColumns))
                                <x-sortable-th name="def_steps_to_reproduce" displayName="Steps to Reproduce"
                                    :sortBy="$sortBy" :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('def_expected_result', $reportColumns))
                                <x-sortable-th name="def_expected_result" displayName="Expected Results"
                                    :sortBy="$sortBy" :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('def_actual_result', $reportColumns))
                                <x-sortable-th name="def_actual_result" displayName="Actual Results"
                                    :sortBy="$sortBy" :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('def_requirement_id', $reportColumns))
                                <th class="px-4 py-3 font-medium text-left">Requirement</th>
                            @endif
                            @if ($reportColumns && in_array('def_assigned_to', $reportColumns))
                                <th class="px-4 py-3 font-medium text-left">Assigned To</th>
                            @endif
                            @if ($reportColumns && in_array('def_created_by', $reportColumns))
                                <th class="px-4 py-3 font-medium text-left">Created By</th>
                            @endif
                            @if ($reportColumns && in_array('created_at', $reportColumns))
                                <x-sortable-th name="created_at" displayName="Created At" :sortBy="$sortBy"
                                    :sortDir="$sortDir" />
                            @endif
                            @if ($reportColumns && in_array('updated_at', $reportColumns))
                                <x-sortable-th name="updated_at" displayName="Closure Date" :sortBy="$sortBy"
                                    :sortDir="$sortDir" />
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($defects as $defect)
                            <tr wire:key='{{ $defect->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                                @if ($reportColumns && in_array('def_name', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->def_name }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_severity', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->def_severity }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_description', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->def_description }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_status', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->def_status }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_type', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->def_type }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_priority', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->def_priority }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_environment', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->def_environment }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_steps_to_reproduce', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->def_steps_to_reproduce }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_expected_result', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->def_expected_result }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_actual_result', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->def_actual_result }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_requirement_id', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->requirement_title ?? '' }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('def_assigned_to', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->assigned_user ?? '' }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('created_user', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->created_user ?? 'System' }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('created_at', $reportColumns))
                                    <td class="px-4 py-3">
                                        {{ $defect->created_at->format('Y-m-d H:i') }}
                                    </td>
                                @endif
                                @if ($reportColumns && in_array('updated_at', $reportColumns))
                                    <td class="px-4 py-3">
                                        @if ($defect->def_status === 'closed')
                                            {{ $defect->updated_at->format('Y-m-d H:i') }}
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%"
                                    class="px-4 py-3 text-center border border-gray-200 dark:border-gray-700">
                                    No defects found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
