<div>
    <div class="flex items-center justify-between flex-wrap gap-4 px-8 py-4 border-b dark:border-gray-700">
        <div class="flex flex-col items-start">
            <a href="{{ route('test-cases') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2"><i
                    class="fa-solid fa-arrow-left"></i> Test Cases</a>
            <h2 class="text-lg font-medium mt-2">{{ $test_case->tc_name }}</h2>
        </div>
        <a href="{{ route('test-case.edit', $test_case->id) }}"
            class="flex items-center justify-center px-4 py-2 font-medium text-md bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md transition-colors duration-300"
            wire:navigate>
            <span><i class="fa-solid fa-pen-to-square"></i> Edit</span>
        </a>
    </div>

    {{-- Detail --}}
    <div class="px-8 py-4 w-full mb-8">
        <div class="flex flex-row items-center space-x-2">
            <span class="text-sm text-gray-500">Created by</span>
            <span class="text-sm text-gray-500">{{ $test_case->created_by->username }}</span>
            <span class="text-sm text-gray-500">on</span>
            <span class="text-sm text-gray-500">{{ $test_case->created_at->format('d M Y') }}</span>
            <span class="text-sm text-gray-500">at</span>
            <span class="text-sm text-gray-500">{{ $test_case->created_at->format('h:i A') }}</span>
        </div>

        {{-- Details --}}
        <div class="border dark:border-gray-700 mt-4 overflow-x-auto">
            <table>
                {{-- Test Case ID --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Test Case ID
                    </th>
                    <td class="w-full px-4 py-3">{{ $test_case->tc_name ?? '' }}</td>
                </tr>
                {{-- Test Case Description --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Summary
                    </th>
                    <td class="w-full px-4 py-3">{{ $test_case->tc_description ?? '' }}</td>
                </tr>
                {{-- Build ID --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Build
                    </th>
                    <td class="w-full px-4 py-3">{{ $test_case->build->name ?? '' }}</td>
                </tr>
                {{-- Module ID --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Module
                    </th>
                    <td class="w-full px-4 py-3">{{ $test_case->module->module_name ?? '' }}</td>
                </tr>
                {{-- Requirement ID --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Requirement
                    </th>
                    <td class="w-full px-4 py-3">
                        @if ($test_case->requirement)
                            <a href="{{ route('requirement.detail', $test_case->requirement->id ?? '') }}"
                                class="hover:text-blue-500 underline" wire:navigate>
                                {{ $test_case->requirement->requirement_title ?? '' }}
                            </a>
                        @endif
                    </td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Test Scenario
                    </th>
                    <td class="w-full px-4 py-3">
                        @if ($test_case->test_scenario)
                            <a href="{{ route('test-scenario.detail', $test_case->test_scenario->id ?? '') }}"
                                class="hover:text-blue-500 underline" wire:navigate>
                                {{ $test_case->test_scenario->ts_name ?? '' }}
                            </a>
                        @endif
                    </td>
                </tr>
                {{-- Test Scenarion ID --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Test Scenario Summary
                    </th>
                    <td class="w-full px-4 py-3">
                        @if ($test_case->test_scenario)
                            {{ $test_case->test_scenario->ts_description ?? '' }}
                        @endif
                    </td>
                </tr>
                {{-- Open Defects --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Open Defects
                    </th>
                    <td class="w-full px-4 py-3">
                        @forelse ($test_case->defects as $defect)
                            <a href="{{ route('defect.detail', $defect->id) }}" class="hover:text-blue-500 underline"
                                wire:navigate>
                                {{ $defect->def_name }}
                            </a>
                        @empty
                            <span class="text-gray-500">No open defects</span>
                        @endforelse
                    </td>
                </tr>
                {{-- Testing Type --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Testing Type
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->tc_testing_type }}
                    </td>
                </tr>
                {{-- Execution Type --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Execution Type
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->tc_execution_type }}
                    </td>
                </tr>
                {{-- Status --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Status
                    </th>
                    <td class="w-full px-4 py-3">
                        @if ($test_case->tc_status === 'approved')
                            <span class="text-green-500">{{ $test_case->tc_status }}</span>
                        @elseif ($test_case->tc_status === 'rejected')
                            <span class="text-red-500">{{ $test_case->tc_status }}</span>
                        @elseif ($test_case->tc_status === 'pending')
                            <span class="text-yellow-500">{{ $test_case->tc_status }}</span>
                        @else
                            <span class="text-gray-500">{{ $test_case->tc_status }}</span>
                        @endif
                    </td>
                </tr>
                {{-- Priority --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
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
                {{-- Assigned To --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Assigned To
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->assigned_to->username ?? '' }}
                    </td>
                </tr>
                {{-- Pre Conditions --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Pre Conditions
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->tc_preconditions ?? '' }}
                    </td>
                </tr>
                {{-- Detailed Steps --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Detailed Steps
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->tc_detailed_steps ?? '' }}
                    </td>
                </tr>
                {{-- Expected Result --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Expected Result
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->tc_expected_results ?? '' }}
                    </td>
                </tr>
                {{-- Post Conditions --}}
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Post Conditions
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $test_case->tc_post_conditions ?? '' }}
                    </td>
                </tr>
                {{-- Estimate Time --}}
                <tr>
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
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

        {{-- Attachments Viewer --}}
        <div x-data="{ open_model: false }" class="w-full mt-8">
            <!-- Toggle Button with Animation -->
            <div @click="open_model = !open_model"
                class="w-full flex items-center justify-between px-4 py-2 cursor-pointer text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300 rounded-t-lg"
                :class="{ 'rounded-lg': !open_model }">
                <h3 class="text-lg font-medium">Attachments</h3>
                <span class="px-2 py-1 bg-white text-gray-900 font-bold rounded transition-transform duration-300"
                    :class="{ 'rotate-180': open_model }" x-text="open_model ? '−' : '+'"></span>
            </div>

            <!-- Attachments Panel with Animation -->
            <div x-show="open_model" x-collapse.duration.300ms
                class="flex flex-col gap-3 overflow-hidden border dark:border-gray-700"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                <!-- Attachments List -->
                <div class="p-4 space-y-3 overflow-y-auto">
                    @forelse ($attachments as $attachment)
                        <div class="bg-gray-100 dark:bg-gray-800 rounded-md p-3 transition-all duration-300 shadow-sm hover:shadow-md"
                            x-data x-intersect="$el.classList.add('animate-fade-in')">
                            <x-file-viewer :file="$attachment" :isPrivate="true" />
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-500 dark:text-gray-400 animate-fade-in">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <p>No attachments available</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Comments Section --}}
        <div x-data="{ open_model: false }" class="w-full mt-4">
            <!-- Toggle Button -->
            <div @click="open_model = !open_model"
                class="w-full flex items-center justify-between px-4 py-2 cursor-pointer text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300 rounded-t-lg"
                :class="{ 'rounded-lg': !open_model }">
                <h3 class="text-lg font-medium">Comments</h3>
                <span class="px-2 py-1 bg-white text-gray-900 font-bold rounded transition-transform duration-300"
                    :class="{ 'rotate-180': open_model }" x-text="open_model ? '−' : '+'"></span>
            </div>

            <!-- Comments Panel -->
            <div x-show="open_model" x-collapse.duration.300ms class="flex flex-col gap-3 overflow-hidden"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                <!-- Comments List -->
                <div class="py-4 flex flex-col gap-3 max-h-[500px] overflow-y-auto pr-2">
                    @foreach ($test_case->comments as $comment)
                        <div wire:key='{{ $comment->id }}'
                            class="bg-gray-100 dark:bg-gray-800 rounded-md px-4 py-3 transition-all duration-300 shadow-sm hover:shadow-md"
                            x-data x-intersect="$el.classList.add('animate-fade-in')">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <p class=" text-gray-700 dark:text-gray-300">
                                        {{ $comment->user->username }}</p>
                                    <span
                                        class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-500">{{ $comment->created_at->format('M j, Y, g:i a') }}
                                </p>
                            </div>
                            <p class="mt-2 font-normal text-gray-800 dark:text-gray-200">{{ $comment->comment }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Comment Form -->
                <div class="dark:border-gray-700">
                    <form wire:submit='saveComment' class="space-y-4">
                        <x-textarea class="w-full" label="Post a new comment" model="comment" rows="3"
                            placeholder="Type your comment here..." />

                        <div class="flex items-center justify-end gap-3">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md transition-colors duration-300"
                                wire:loading.attr="disabled" wire:target="saveComment">
                                <span wire:loading.remove wire:target="saveComment">Post Comment</span>
                                <span wire:loading wire:target="saveComment" class="flex items-center gap-2">
                                    <span>Posting...</span>
                                    <i class="fa-solid fa-spinner fa-spin"></i>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Version History --}}
        <div x-data="{ open_model: false }" class="w-full mt-4">
            <!-- Toggle Button -->
            <div @click="open_model = !open_model"
                class="w-full flex items-center justify-between px-4 py-2 cursor-pointer text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300 rounded-t-lg"
                :class="{ 'rounded-lg': !open_model }">
                <h3 class="text-lg font-medium">Version History</h3>
                <span class="px-2 py-1 bg-white text-gray-900 font-bold rounded transition-transform duration-300"
                    :class="{ 'rotate-180': open_model }" x-text="open_model ? '−' : '+'"></span>
            </div>

            <!-- History Panel -->
            <div x-show="open_model" x-collapse.duration.300ms class="flex flex-col gap-3 overflow-hidden mt-3"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                <!-- Version History Items -->
                @foreach ($test_case_versions as $index => $version)
                    @if ($index === 0)
                        @continue
                    @endif

                    @php
                        $previousVersion = $index > 0 ? $test_case_versions[$index - 1] : null;
                    @endphp

                    <div class="bg-gray-100 dark:bg-gray-800 shadow-sm rounded-md px-4 py-3 transition-all duration-300"
                        x-data="{ showDetails: {{ $index === 1 ? 'true' : 'false' }} }">
                        <!-- Version Header -->
                        <div class="flex items-center justify-between text-gray-500 mb-3 cursor-pointer"
                            @click="showDetails = !showDetails">
                            <p>Modified by {{ $version->created_by->name }}</p>
                            <div class="flex items-center gap-3">
                                <span class="transition-transform duration-300"
                                    :class="{ 'rotate-180': showDetails }">▼</span>
                            </div>
                            <p>{{ $version->created_at->format('M j, Y, g:i a') }}</p>
                        </div>

                        <!-- Version Details -->
                        <div x-show="showDetails" x-collapse.duration.300ms class="space-y-3"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0">
                            <!-- Build ID -->
                            @if ($version->build?->id !== $previousVersion->build?->id)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Build ID',
                                    'current' => $version->build->name ?? 'None',
                                    'previous' => $previousVersion->build->name ?? 'None',
                                ])
                            @endif

                            <!-- Module ID -->
                            @if ($version->module?->id !== $previousVersion->module?->id)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Module ID',
                                    'current' => $version->module->module_name ?? 'None',
                                    'previous' => $previousVersion->module->module_name ?? 'None',
                                ])
                            @endif

                            <!-- Requirement ID -->
                            @if ($version->requirement?->id !== $previousVersion->requirement?->id)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Requirement ID',
                                    'current' => $version->requirement->requirement_title ?? 'None',
                                    'previous' => $previousVersion->requirement->requirement_title ?? 'None',
                                ])
                            @endif
                            <!-- Test Scenario ID -->
                            @if ($version->test_scenario?->id !== $previousVersion->test_scenario?->id)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Test Scenario ID',
                                    'current' => $version->test_scenario->ts_name ?? 'None',
                                    'previous' => $previousVersion->test_scenario->ts_name ?? 'None',
                                ])
                            @endif
                            <!-- Test Scenario Summary -->
                            @if ($version->test_scenario?->ts_description !== $previousVersion->test_scenario?->ts_description)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Test Scenario Summary',
                                    'current' => $version->test_scenario->ts_description ?? 'None',
                                    'previous' => $previousVersion->test_scenario->ts_description ?? 'None',
                                ])
                            @endif
                            <!-- Test Case Description -->
                            @if ($version->tc_description !== $previousVersion->tc_description)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Test Case Description',
                                    'current' => $version->tc_description ?? 'None',
                                    'previous' => $previousVersion->tc_description ?? 'None',
                                ])
                            @endif
                            <!-- Pre Conditions -->
                            @if ($version->tc_preconditions !== $previousVersion->tc_preconditions)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Pre Conditions',
                                    'current' => $version->tc_preconditions ?? 'None',
                                    'previous' => $previousVersion->tc_preconditions ?? 'None',
                                ])
                            @endif
                            <!-- Detailed Steps -->
                            @if ($version->tc_detailed_steps !== $previousVersion->tc_detailed_steps)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Detailed Steps',
                                    'current' => $version->tc_detailed_steps ?? 'None',
                                    'previous' => $previousVersion->tc_detailed_steps ?? 'None',
                                ])
                            @endif
                            <!-- Expected Result -->
                            @if ($version->tc_expected_results !== $previousVersion->tc_expected_results)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Expected Result',
                                    'current' => $version->tc_expected_results ?? 'None',
                                    'previous' => $previousVersion->tc_expected_results ?? 'None',
                                ])
                            @endif
                            <!-- Post Conditions -->
                            @if ($version->tc_post_conditions !== $previousVersion->tc_post_conditions)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Post Conditions',
                                    'current' => $version->tc_post_conditions ?? 'None',
                                    'previous' => $previousVersion->tc_post_conditions ?? 'None',
                                ])
                            @endif
                            <!-- Estimate Time -->
                            @if ($version->tc_estimated_time !== $previousVersion->tc_estimated_time)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Estimate Time',
                                    'current' => $version->tc_estimated_time ?? 'None',
                                    'previous' => $previousVersion->tc_estimated_time ?? 'None',
                                ])
                            @endif
                            <!-- Testing Type -->
                            @if ($version->tc_testing_type !== $previousVersion->tc_testing_type)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Testing Type',
                                    'current' => $version->tc_testing_type ?? 'None',
                                    'previous' => $previousVersion->tc_testing_type ?? 'None',
                                ])
                            @endif
                            <!-- Execution Type -->
                            @if ($version->tc_execution_type !== $previousVersion->tc_execution_type)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Execution Type',
                                    'current' => $version->tc_execution_type ?? 'None',
                                    'previous' => $previousVersion->tc_execution_type ?? 'None',
                                ])
                            @endif
                            <!-- Status -->
                            @if ($version->tc_status !== $previousVersion->tc_status)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Status',
                                    'current' => $version->tc_status ?? 'None',
                                    'previous' => $previousVersion->tc_status ?? 'None',
                                ])
                            @endif
                            <!-- Priority -->
                            @if ($version->tc_priority !== $previousVersion->tc_priority)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Priority',
                                    'current' => $version->tc_priority ?? 'None',
                                    'previous' => $previousVersion->tc_priority ?? 'None',
                                ])
                            @endif
                            <!-- Assigned To -->
                            @if ($version->assigned_to?->id !== $previousVersion->assigned_to?->id)
                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Assigned To',
                                    'current' => $version->assigned_to->username ?? 'None',
                                    'previous' => $previousVersion->assigned_to->username ?? 'None',
                                ])
                            @endif

                            <!-- Attachments -->
                            @if ($version->attachments != $previousVersion->attachments)
                                @php
                                    // Format attachments for display
                                    $currentAttachments = is_array($version->attachments)
                                        ? $version->attachments
                                        : json_decode($version->attachments, true);
                                    $previousAttachments = $previousVersion
                                        ? (is_array($previousVersion->attachments)
                                            ? $previousVersion->attachments
                                            : json_decode($previousVersion->attachments, true))
                                        : [];

                                    // Create display strings
                                    $currentDisplay = !empty($currentAttachments)
                                        ? implode(', ', $currentAttachments)
                                        : 'None';
                                    $previousDisplay = !empty($previousAttachments)
                                        ? implode(', ', $previousAttachments)
                                        : 'None';
                                @endphp

                                @include('livewire.test-case.partials.version-diff', [
                                    'field' => 'Attachments',
                                    'current' => $currentDisplay,
                                    'previous' => $previousDisplay,
                                    'isAttachment' => true,
                                ])
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
