<div x-data='{showModel: false}' class="bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700 overflow-hidden">
    <!-- Card Header -->
    <div
        class="flex items-center justify-between px-5 py-4 border-b border-green-500 dark:border-green-700 bg-gray-50 dark:bg-gray-700/30">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
            <span class="w-2 h-2 mr-1 bg-green-500 dark:bg-green-600"></span>
            Test Cases
        </h3>
        <button type="button" title="Filter Test Cases" @click="showModel = true"
            class="p-1.5 rounded-full text-gray-500 hover:text-green-600 hover:bg-green-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-green-300 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
        </button>
    </div>

<!-- Card Content -->
<div class="px-5 py-4">
    <a href="{{ route('test-cases') }}" title="View Test Cases" wire:navigate class="group">
        <div class="flex items-baseline gap-2">
            <!-- Total Test Cases -->
            <span class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                {{ $total_test_cases ?? '0' }}
            </span>
            
            <!-- Separator -->
            <span class="text-xl font-normal text-gray-400 dark:text-gray-500">/</span>
            
            <!-- Unapproved Cases -->
            <span class="text-sm font-medium text-gray-600 dark:text-gray-300 ">
                {{ $unapproved_test_cases }} Unapproved
            </span>
        </div>
    </a>
</div>


    <div x-show="showModel" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Modal Container -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md max-h-[90vh] flex flex-col overflow-hidden"
            x-show="showModel" @click.away="showModel = false">

            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Filter Test Cases</h4>
                </div>
                <button @click="showModel = false"
                    class="p-1 rounded-full text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="px-6 py-5 space-y-5 overflow-y-auto flex-grow">
                <!-- Build ID -->
                <x-single-select-box label='Build' model='build_id' live='true'>
                    <option value="all">All</option>
                    @forelse ($builds as $build)
                        <option class="truncate" wire:key='{{ $build->id }}' value="{{ $build->id }}">
                            {{ $build->name }}
                        </option>
                    @empty
                        <option disabled>No builds available</option>
                    @endforelse
                </x-single-select-box>

                <!-- Module -->
                <x-single-select-box label='Module' model='module_id' live='true'>
                    <option value="all">All</option>
                    @isset($modules)
                        @foreach ($modules as $module)
                            <option class="truncate" wire:key='{{ $module->id }}' value="{{ $module->id }}">
                                {{ $module->module_name }}
                            </option>
                        @endforeach
                    @endisset
                </x-single-select-box>

                <!-- Requirement -->
                <x-single-select-box label='Requirement' model='requirement_id' live='true'>
                    <option value="all">All</option>
                    @isset($requirements)
                        @foreach ($requirements as $requirement)
                            <option class="truncate" wire:key='{{ $requirement->id }}' value="{{ $requirement->id }}">
                                {{ $requirement->requirement_title }}
                            </option>
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

                {{-- Test case Type --}}
                <x-single-select-box label='Testing Type' model='testing_type' live='true'>
                    <option value="all">All</option>
                    <option value="field-validation">Field Validation</option>
                    <option value="content">Content</option>
                    <option value="cross-browser/os">Cross Browser/OS</option>
                    <option value="ui/ux">UI/UX</option>
                    <option value="security">Security</option>
                    <option value="performance">Performance</option>
                    <option value="functional">Functional</option>
                </x-single-select-box>

                {{-- Status --}}
                <x-single-select-box label='Status' model='status' live='true'>
                    <option value="all">All</option>
                    <option value="pending">Pending Approval</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </x-single-select-box>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-between px-6 py-4 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30">
                <button type="button" wire:click='clearFilters'
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                    Clear Filters
                </button>
                <div class="flex gap-3">
                    <button type="button" @click="showModel = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 rounded-md transition-colors">
                        Close
                    </button>
                    <button type="button" @click="showModel = false"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 rounded-md transition-colors shadow-sm">
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
