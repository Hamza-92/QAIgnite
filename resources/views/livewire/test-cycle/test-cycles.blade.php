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

    <div
        class="px-8 py-4 flex items-center flex-wrap gap-4 justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg">Test Cycle Management</h2>
        <a href="{{ route('test-cycle.create') }}" wire:navigate title="Create a new Test Cycle to execute Test Cases"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer">
            <i class="fa-solid fa-plus"></i>
            Test Cycle
        </a>
    </div>

    <div class="px-8 py-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            {{-- Items per page --}}
            <x-table-entries entries="perPage" />

            {{-- Search Field --}}
            <x-search-field search='search' placeholder='Search...' resetMethod='resetSearch' />
        </div>

        {{-- Table --}}
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <x-sortable-th name="name" displayName="Cycle" :sortBy="$sortBy" :sortDir="$sortDir"
                            class="w-[15%]" />
                        <th scope="col" class="px-4 py-3 font-medium cursor-pointer w-[10%]">Build</th>
                        <x-sortable-th name="start_date" displayName="Start Date" :sortBy="$sortBy" :sortDir="$sortDir"
                            class="w-[10%]" />
                        <x-sortable-th name="end_date" displayName="End Date" :sortBy="$sortBy" :sortDir="$sortDir"
                            class="w-[10%]" />
                        <th scope="col" class="px-4 py-3 font-medium cursor-pointer w-[15%]">Assigned To</th>
                        <th scope="col" class="px-4 py-3 font-medium cursor-pointer w-[25%]">Results</th>
                        <!-- Wider column -->
                        <x-sortable-th name="status" displayName="Status" :sortBy="$sortBy" :sortDir="$sortDir"
                            class="w-[10%]" />
                        <th scope="col" class="px-4 py-3 font-medium cursor-pointer w-[5%]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($test_cycles as $test_cycle)
                        <tr wire:key='{{ $test_cycle->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">
                                <a href="{{ route('test-case-execution.list', [$test_cycle->id]) }}" wire:navigate
                                    class="underline hover:text-blue-500">{{ $test_cycle->name }}</a>
                            </td>
                            <td class="px-4 py-3">
                                <span title="{{ $test_cycle->build->name ?? '--' }}">
                                    {{ Str::limit($test_cycle->build->name ?? '--', 20) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $test_cycle->start_date?->format('M d, Y') ?? '--' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $test_cycle->end_date?->format('M d, Y') ?? '--' }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($test_cycle->assignees->isNotEmpty())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($test_cycle->assignees as $user)
                                            <span title="{{ $user->name }}"
                                                class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs font-medium px-2.5 py-0.5 rounded whitespace-nowrap">
                                                {{ $user->username }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400 text-sm italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $passed = $test_cycle->result_counts['passed'];
                                    $failed = $test_cycle->result_counts['failed'];
                                    $not_run = $test_cycle->result_counts['not_executed'];
                                    $total = $passed + $failed + $not_run;

                                    $getPercent = fn($count) => $total > 0 ? round(($count / $total) * 100) : 0;
                                @endphp

                                <div class="flex items-center w-full group">
                                    <div
                                        class="w-full h-6 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden flex text-xs font-semibold">
                                        @if ($passed)
                                            <div class="bg-green-600 flex items-center justify-center relative transition-all duration-700 ease-in-out hover:opacity-80"
                                                style="width: {{ $getPercent($passed) }}%;"
                                                title="Passed: {{ $passed }} ({{ $getPercent($passed) }}%)">
                                                <span class="px-1 text-white">{{ $passed }}</span>
                                            </div>
                                        @endif
                                        @if ($failed)
                                            <div class="bg-red-600 flex items-center justify-center relative transition-all duration-700 ease-in-out hover:opacity-80"
                                                style="width: {{ $getPercent($failed) }}%;"
                                                title="Failed: {{ $failed }} ({{ $getPercent($failed) }}%)">
                                                <span class="px-1 text-white">{{ $failed }}</span>
                                            </div>
                                        @endif
                                        @if ($not_run)
                                            <div class="bg-yellow-400 text-black dark:text-white flex items-center justify-center relative transition-all duration-700 ease-in-out hover:opacity-80"
                                                style="width: {{ $getPercent($not_run) }}%;"
                                                title="Not Run: {{ $not_run }} ({{ $getPercent($not_run) }}%)">
                                                <span class="px-1">{{ $not_run }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'on hold' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
                                        'in progress' =>
                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'completed' =>
                                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    ];
                                @endphp
                                <span
                                    class="text-xs font-medium px-2.5 py-0.5 rounded-full whitespace-nowrap {{ $statusColors[strtolower($test_cycle->status)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ ucfirst($test_cycle->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative" x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="px-3 py-1 rounded-md bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 cursor-pointer transition-colors"
                                        aria-label="Actions menu">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-transition
                                        class="absolute divide-x divide-gray-200 dark:divide-gray-700 top-1/2 right-full mr-3 transform -translate-y-1/2 p-1 text-md bg-white dark:bg-gray-800 rounded-md border dark:border-gray-700 shadow-lg z-10 flex items-center justify-center before:absolute before:top-1/2 before:left-full before:-translate-y-1/2 before:w-0 before:h-0 before:border-[6px] before:border-t-transparent before:border-b-transparent before:border-l-white dark:before:border-l-gray-800 before:border-r-transparent">
                                        <!-- Add Test Cases -->
                                        <a href="{{ route('test-cycle.assign_test_cases', $test_cycle->id) }}"
                                            wire:navigate
                                            class="px-3 py-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors cursor-pointer"
                                            title="Add Test Cases">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                        <!-- Edit Button -->
                                        <a href="{{ route('test-cycle.edit', $test_cycle->id) }}" wire:navigate
                                            class="px-3 py-1 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors cursor-pointer"
                                            title="Edit Test Case">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        {{-- Clone test cycle --}}
                                        <button type="button" wire:click='cloneTestCycle({{$test_cycle->id}})'
                                            class="px-3 py-1 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 transition-colors cursor-pointer"
                                            title="Clone This Cycle">
                                            <i class="fa-solid fa-clone"></i>
                                        </button>

                                        {{-- copy url button --}}
                                        <button type="button" @click="navigator.clipboard.writeText('{{ route('test-case-execution.list', [$test_cycle->id]) }}'); $dispatch('notify', { message: 'URL has been copied to clipboard.', type: 'success' })"
                                            class="px-3 py-1 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 transition-colors cursor-pointer"
                                            title="Copy URL">
                                            <i class="fa-solid fa-link"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" wire:loading.attr="disabled"
                                            wire:target="deleteTestCycle({{ $test_cycle->id }})"
                                            @click="Swal.fire({
                                                title: 'Are you sure?',
                                                text: 'The test cycle will be permanently deleted!',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Delete'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $wire.deleteTestCycle({{ $test_cycle->id }})
                                                }
                                            })"
                                            class="px-3 py-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors cursor-pointer"
                                            title="Delete">
                                            <i wire:loading.remove wire:target="deleteTestCycle({{ $test_cycle->id }})"
                                                class="fa-solid fa-trash-can"></i>
                                            <span wire:loading wire:target="deleteTestCycle({{ $test_cycle->id }})"
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
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No test cycles found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="mt-4">
            {{ $test_cycles->links() }}
        </div>
    </div>
</div>
