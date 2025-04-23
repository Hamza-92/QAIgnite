<div x-data='defect_detail:true'>
    <div class="flex items-center justify-between flex-wrap gap-4 px-8 py-4 border-b dark:border-gray-700">
        <div class="flex flex-col items-start">
            <a href="{{ route('test-case-execution.list', [$test_cycle_id]) }}" wire:navigate
                class="text-blue-500 py-1 rounded-md space-x-2"><i class="fa-solid fa-arrow-left"></i> Test Cycle</a>
            <h2 class="text-lg font-medium mt-2">Test Case Execution</h2>
        </div>
    </div>
    {{-- Detail --}}
    <div class="px-8 py-4 w-full mb-8">
        {{-- Details --}}
        <div class="border dark:border-gray-700 mt-4 overflow-x-auto">
            <table>
                {{-- Test Case Creation Date --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r sm:whitespace-nowrap dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Test Case Creation Date
                    </th>
                    <td class="w-full px-4 py-3">{{ $test_case->created_at->format('d-m-Y H:i:s') ?? '' }}</td>
                </tr>
                {{-- Test Case ID --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Test Case ID
                    </th>
                    <td class="w-full px-4 py-3">
                        <a class="underline hover:text-blue-500"
                            href="{{ route('test-case.detail', [$test_case->id]) }}" target="_blank" wire:navigate>
                            {{ $test_case->tc_name ?? '' }}
                        </a>
                    </td>
                </tr>
                {{-- Testing Type --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Testing Type
                    </th>
                    <td class="w-full px-4 py-3">{{ ucfirst($test_case->tc_testing_type) ?? '' }}</td>
                </tr>
                {{-- Testing Execution Type --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Execution Type
                    </th>
                    <td class="w-full px-4 py-3">{{ ucfirst($test_case->tc_execution_type) ?? '' }}</td>
                </tr>
                {{-- Priority --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Priority
                    </th>
                    <td class="w-full px-4 py-3">
                        @if ($test_case->tc_priority === 'high')
                            <span class="text-red-500">{{ $test_case->tc_priority }}</span>
                        @elseif ($test_case->tc_priority === 'medium')
                            <span class="text-yellow-500">{{ $test_case->tc_priority }}</span>
                        @elseif ($test_case->tc_priority === 'low')
                            <span class="text-green-500">{{ $test_case->tc_priority }}</span>
                        @else
                            <span>{{ $test_case->tc_priority }}</span>
                        @endif
                    </td>
                </tr>
                {{-- Summary --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Summary
                    </th>
                    <td class="w-full px-4 py-3">{{ $test_case->tc_description ?? '' }}</td>
                </tr>
                {{-- Assign To --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Assign To
                    </th>
                    <td class="w-full px-4 py-3">{{ $test_case->assigned_to->username ?? '' }}</td>
                </tr>
                {{-- Pre Conditions --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Pre Conditions
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->tc_preconditions ?? '' }}
                    </td>
                </tr>
                {{-- Detailed Steps --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Detailed Steps
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->tc_detailed_steps ?? '' }}
                    </td>
                </tr>
                {{-- Expected Result --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Expected Result
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->tc_expected_results ?? '' }}
                    </td>
                </tr>
                {{-- Post Conditions --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Post Conditions
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->tc_post_conditions ?? '' }}
                    </td>
                </tr>
                {{-- Estimate Time --}}
                <tr>
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                        Estimate Time
                    </th>
                    <td class="w-full px-4 py-3">
                        @php
                            $hours = intdiv($test_case->tc_estimated_time ?? 0, 60);
                            $minutes = ($test_case->tc_estimated_time ?? 0) % 60;
                        @endphp
                        {{ $hours }}h {{ $minutes }}m
                    </td>
                </tr>
            </table>
        </div>

        {{-- Test Case Executions --}}
        <div x-data="{ open_model: true }" class="w-full mt-8">
            <div @click="open_model = !open_model"
                class="w-full flex items-center justify-between px-4 py-2 cursor-pointer text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300 rounded-t-lg"
                :class="{ 'rounded-lg': !open_model }">
                <h3 class="text-lg font-medium">Executions</h3>
                <span class="px-2 py-1 bg-white text-gray-900 font-bold rounded transition-transform duration-300"
                    :class="{ 'rotate-180': open_model }" x-text="open_model ? '−' : '+'"></span>
            </div>

            <div x-show="open_model" x-collapse.duration.300ms class="flex flex-col gap-3 overflow-x-auto"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                <table class="mt-2 border dark:border-gray-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                                Date
                            </th>
                            <th class="px-4 py-3 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                                Comments
                            </th>
                            <th class="px-4 py-3 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                                Tested By
                            </th>
                            <th class="px-4 py-3 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                                Status
                            </th>
                            <th class="px-4 py-3 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                                Defect ID
                            </th>
                            <th class="px-4 py-3 bg-gray-100 dark:bg-gray-800 text-left font-medium">
                                Time
                            </th>
                            <th class="px-4 py-3 bg-gray-100 dark:bg-gray-800 font-medium">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($test_case_executions as $execution)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-3">
                                    {{ $execution->created_at }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $execution->comment }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $execution->executedBy->username }}
                                </td>
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
                                        class="px-3 py-1 rounded-full {{ $statusClasses[$execution->status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                        {{ $execution->status }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    @if ($execution->defect)
                                        <button type="button"
                                            wire:click='fetchDefectDetails({{ $execution->defect->id }})'
                                            class="underline hover:text-blue-500">
                                            {{ $execution->defect->def_name ?? '' }}
                                        </button>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    {{ gmdate('H:i:s', $execution->execution_time) }}
                                </td>
                                <td class="px-4 py-3 flex items-center gap-2 justify-center">
                                    @if ($execution->status == 'Failed' && !$execution->defect_id)
                                        <a href="{{ route('test-case-execution.attach-defect', [$test_cycle_id, $test_case_id, $execution->id]) }}"
                                            wire:navigate
                                            class="px-2 py-1 rounded-md border dark:border-gray-600 space-x-2 text-red-500 hover:bg-red-500 hover:text-white transition-colors duration-300ms">
                                            <i class="fa-solid fa-bug"></i> Add Defect
                                        </a>
                                    @endif
                                    <div class="relative" x-data="{ open: false }">
                                        <button type="button" @click="open = !open"
                                            class="px-3 py-1 rounded-md bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 cursor-pointer transition-colors"
                                            aria-label="Actions menu">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div x-show="open" @click.outside="open = false" x-transition
                                            class="absolute divide-x divide-gray-200 dark:divide-gray-700 top-1/2 right-full mr-3 transform -translate-y-1/2 p-1 text-md bg-white dark:bg-gray-800 rounded-md border dark:border-gray-700 shadow-lg z-10 flex items-center justify-center before:absolute before:top-1/2 before:left-full before:-translate-y-1/2 before:w-0 before:h-0 before:border-[6px] before:border-t-transparent before:border-b-transparent before:border-l-white dark:before:border-l-gray-800 before:border-r-transparent">
                                            <!-- Attach Files -->
                                            <button type="button" title="Attach Files"
                                                class="px-3 py-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors cursor-pointer">
                                                <i class="fa-solid fa-paperclip"></i>
                                            </button>
                                            <!-- View Attached Files Button -->
                                            <button type="button" title="View Attached Files"
                                                class="px-3 py-1 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors cursor-pointer">
                                                <i class="fa-solid fa-folder-open"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- <tr>
                                <td colspan="100%" class="px-4 py-3 text-center">N/A</td>
                            </tr> --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{-- Execute Test Case --}}
            <form wire:submit.prevent='save' class="space-y-4">
                <div class="mt-8 px-8 py-4 bg-gray-100 dark:bg-gray-800 border dark:border-gray-700">
                    <h3 class="text-blue-500 text-2xl font-medium">Test Case Execution Time</h3>
                    <div class="flex items-center gap-4 py-4" wire:poll.1s>
                        {{-- Display Time Counting --}}
                        <div
                            class="px-8 py-2 bg-white dark:bg-gray-900 shadow-sm rounded-md text-3xl font-mono tracking-tighter inline-flex items-center gap-4">
                            <i class="fa-solid fa-stopwatch mr-2 text-gray-500"></i>
                            <span class="text-gray-800 dark:text-gray-200">{{ $formatted_time }}</span>
                        </div>
                        {{-- Display Buttons --}}
                        @if (!$is_running && !$executionSession->started_at)
                            <button wire:click="start" type="button"
                                class="px-4 py-2 text-2xl bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 text-white rounded w-36 text-center">Start</button>
                        @elseif ($is_running)
                            <button wire:click="pause" type="button"
                                class="px-4 py-2 text-2xl bg-yellow-500 text-white rounded hover:bg-yellow-600 w-36 text-center">Pause</button>
                        @else
                            <button wire:click="resume" type="button"
                                class="px-4 py-2 text-2xl bg-green-600 text-white rounded hover:bg-green-700 w-36 text-center">Resume</button>
                        @endif
                    </div>
                </div>
                <x-single-select-box label='Status' model='status' required='true'>
                    <option value="select">Select</option>
                    <option value="Passed">Passed</option>
                    <option value="Failed">Failed</option>
                    <option value="Not Executed">Not Executed</option>
                </x-single-select-box>

                {{-- Description --}}
                <x-textarea label='Comment' model='comment' rows='5'></x-textarea>

                <div class="py-16 flex items-center justify-center gap-4">
                    <button type="submit"
                        class="px-6 py-2 w-48 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white text-2xl text-center cursor-pointer rounded-md">
                        Execute <i wire:loading wire:target='save' class="fa-solid fa-spinner fa-spin"></i>
                    </button>
                    <a href="{{ route('test-case-execution.list', [$test_cycle_id]) }}" wire:navigate
                        class="px-6 py-2 w-48 bg-gray-200 hover:bg-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 text-2xl text-center cursor-pointer rounded-md">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Defect Detail Modal --}}
    <div x-show="$wire.defect_detail_model" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex items-center justify-center bg-gray-500/50 backdrop-blur-sm z-50" x-cloak>

        {{-- Modal Box --}}
        <div class="w-full mx-4 md:w-[700px] lg:w-[800px] max-h-[90vh] bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden flex flex-col"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            @keydown.escape.window="$wire.closeModel()">

            {{-- Modal Header --}}
            <div
                class="p-5 flex justify-between items-center border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-900 sticky top-0 z-10">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 truncate max-w-[80%]">
                    Defect Details: <span
                        class="text-blue-600 dark:text-blue-400">{{ $defect_detail->def_name ?? 'N/A' }}</span>
                </h2>
                <button wire:click='closeModel' type="button"
                    class="px-2 py-1  text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xl transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                    aria-label="Close modal">
                    <i
                        class="fa-solid fa-xmark"></i>
                </button>
            </div>

            {{-- Modal Content (scrollable) --}}
            <div class="flex-1 overflow-y-auto p-5 md:p-6">
                <div class="space-y-6">
                    {{-- Status Badge --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold
                       @if (($defect_detail->def_status ?? '') === 'Open') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200
                       @elseif(($defect_detail->def_status ?? '') === 'Closed') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                       @else bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200 @endif">
                            {{ $defect_detail->def_status ?? 'Unknown' }}
                        </span>
                    </div>

                    {{-- Description --}}
                    <div>
                        <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Description</h3>
                        <div
                            class="text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-900 p-3 rounded-md">
                            {{ $defect_detail->def_description ?? 'No description provided' }}
                        </div>
                    </div>

                    {{-- Additional Details --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Reported By</h3>
                            <p class="text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                {{ $defect_detail->createdBy->username ?? 'Unknown' }}
                            </p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Reported Date</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ optional($defect_detail)->created_at?->format('M j, Y, g:i a') ?? 'Unknown' }}
                            </p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Severity</h3>
                            <p class="text-gray-600 dark:text-gray-400 capitalize">
                                {{ $defect_detail->def_severity ?? 'Not specified' }}
                            </p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Priority</h3>
                            <p class="text-gray-600 dark:text-gray-400 capitalize">
                                {{ $defect_detail->def_priority ?? 'Not specified' }}
                            </p>
                        </div>
                    </div>

                    {{-- Comments Section --}}
                    <div>
                        <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Comments</h3>

                        <!-- Comments List -->
                        <div class="space-y-2 gap-3">
                            @isset($defect_detail->comments)
                                @forelse ($defect_detail->comments as $comment)
                                    <div wire:key='{{ $comment->id }}'
                                        class="bg-gray-100 dark:bg-gray-900 rounded-md px-4 py-3 transition-all duration-300"
                                        x-data x-intersect="$el.classList.add('animate-fade-in')">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <p class="text-gray-700 dark:text-gray-300">
                                                    {{ $comment->user->username ?? 'Unknown User' }}</p>
                                                <span class="text-xs text-gray-500">
                                                    {{ $comment->created_at->diffForHumans() ?? '' }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500">
                                                {{ $comment->created_at->format('M j, Y, g:i a') ?? '' }}
                                            </p>
                                        </div>
                                        <p class="mt-2 font-normal text-gray-800 dark:text-gray-200">
                                            {{ $comment->comment ?? '' }}</p>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                                        No comments yet!
                                    </div>
                                @endforelse
                            @else
                                <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                                    Comments cannot be loaded at this time.
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div
                class="p-4 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex flex-col sm:flex-row justify-between items-center gap-3 sticky bottom-0">
                <button wire:click='closeModel' type="button"
                    class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 rounded-md transition-colors w-full sm:w-auto order-2 sm:order-1">
                    Close
                </button>
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto order-1 sm:order-2">
                    <a href="{{route('defect.detail', $defect_detail->id ?? '')}}" wire:navigate
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors w-full sm:w-auto flex items-center justify-center gap-2">
                        <i class="fas fa-external-link-alt"></i>
                        View Full Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
