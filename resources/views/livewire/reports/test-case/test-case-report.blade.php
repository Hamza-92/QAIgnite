<div>
    <div class="px-8 pt-2 w-full flex items-end gap-1 border-b dark:border-gray-700 transition-colors duration-200">
        <a href="{{ route('reports.defect-report') }}" wire:navigate class="p-2 hover:border-b-2 border-blue-500">Defect
            Report</a>
        <a href="{{ route('reports.test-case-report') }}" wire:navigate class="p-2 border-b-2 border-blue-500">Test Case
            Report</a>
    </div>
    <div
        class="px-8 py-4 flex items-center flex-wrap gap-4 justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg">Test Case Report</h2>
    </div>

    {{-- Report Filter --}}
    <div class="px-8 py-4">
        <div x-data="{ open_model: true }" class="w-full">
            <div @click="open_model = !open_model"
                class="w-full flex items-center justify-between px-4 py-2 cursor-pointer text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300 rounded-t-md"
                :class="{ 'rounded-md': !open_model }">
                <h3 class="text-lg font-medium">Test Case Report Filter</h3>
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

                    {{-- Test Case Status --}}
                    <x-single-select-box label='Test Case Status' model='test_case_status'>
                        <option value="all">All</option>
                        <option value="Pending Approval">Pending Approval</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </x-single-select-box>

                    {{-- Execution Status --}}
                    <x-single-select-box label='Execution Status' model='execution_status'>
                        <option value="all">All</option>
                        <option value="passed">Passed</option>
                        <option value="failed">Failed</option>
                        <option value="not run">Not Run</option>
                    </x-single-select-box>

                    {{-- Testing Type --}}
                    <x-single-select-box label='Testing Type' model='testing_type'>
                        <option value="">Select</option>
                        <option value="field-validation">Field Validation</option>
                        <option value="content">Content</option>
                        <option value="cross-browser/os">Cross Browser/OS</option>
                        <option value="ui/ux">UI/UX</option>
                        <option value="security">Security</option>
                        <option value="performance">Performance</option>
                        <option value="functional">Functional</option>
                    </x-single-select-box>

                    {{-- Assign To --}}
                    <x-single-select-box label='Assign To' model='tc_assigned_to'>
                        <option value="">Select</option>
                        @isset($assigned_users)
                            @foreach ($assigned_users as $user)
                                <option class="overflow-ellipsis" wire:key='{{ $user->id }}'
                                    value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        @endisset
                    </x-single-select-box>
                </div>
            </div>
        </div>
    </div>
</div>
