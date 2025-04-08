<div>
    <div class="flex items-center justify-between flex-wrap gap-4 px-8 py-4 border-b dark:border-gray-700">
        <div class="flex flex-col items-start">
            <a href="{{ route('defects') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2"><i
                    class="fa-solid fa-arrow-left"></i> Defects</a>
            <h2 class="text-lg font-medium mt-2">{{ $defect->def_name }}</h2>
        </div>
        <a href="{{ route('defect.edit', $defect->id) }}"
            class="flex items-center justify-center px-4 py-2 font-medium text-md bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md transition-colors duration-300"
            wire:navigate>
            <span><i class="fa-solid fa-pen-to-square"></i> Edit</span>
        </a>
    </div>

    {{-- Detail --}}
    <div class="px-8 py-4 w-full mb-8">
        {{-- Created By --}}
        <div class="flex flex-row items-center space-x-2">
            <span class="text-sm text-gray-500">Created by</span>
            <span class="text-sm text-gray-500">{{ $defect->createdBy->username }}</span>
            <span class="text-sm text-gray-500">on</span>
            <span class="text-sm text-gray-500">{{ $defect->created_at->format('d M Y') }}</span>
            <span class="text-sm text-gray-500">at</span>
            <span class="text-sm text-gray-500">{{ $defect->created_at->format('h:i A') }}</span>
        </div>

        {{-- Details --}}
        <div class="border dark:border-gray-700 mt-4 overflow-x-auto">
            <table>
                {{-- Defect ID --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Defect ID
                    </th>
                    <td class="w-full px-4 py-3">{{ $defect->def_name ?? '' }}</td>
                </tr>
                {{-- Defect Description --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Description
                    </th>
                    <td class="w-full px-4 py-3">{{ $defect->def_description ?? '' }}</td>
                </tr>
                {{-- Defect Build --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Build
                    </th>
                    <td class="w-full px-4 py-3">{{ $defect->build->name ?? '' }}</td>
                </tr>
                {{-- Defect Module --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Module
                    </th>
                    <td class="w-full px-4 py-3">{{ $defect->module->module_name ?? '' }}</td>
                </tr>
                {{-- Defect Requirement --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Requirement
                    </th>
                    <td class="w-full px-4 py-3">
                        @if ($defect->requirement)
                            <a href="{{ route('requirement.detail', $defect->requirement->id ?? '') }}"
                                class="hover:text-blue-500 underline" wire:navigate>
                                {{ $defect->requirement->requirement_title ?? '' }}
                            </a>
                        @endif
                    </td>
                </tr>
                {{-- Defect Test Scenario --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Test Scenario
                    </th>
                    <td class="w-full px-4 py-3">
                        @if ($defect->testScenario)
                            <a href="{{ route('test-scenario.detail', $defect->testScenario->id ?? '') }}"
                                class="hover:text-blue-500 underline" wire:navigate>
                                {{ $defect->testScenario->ts_name ?? '' }}
                            </a>
                        @endif
                    </td>
                </tr>
                {{-- Defect Test Case --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Test Case
                    </th>
                    <td class="w-full px-4 py-3">
                        @if ($defect->testCase)
                            <a href="{{ route('test-case.detail', $defect->testCase->id ?? '') }}"
                                class="hover:text-blue-500 underline" wire:navigate>
                                {{ $defect->testCase->tc_name ?? '' }}
                            </a>
                        @endif
                    </td>
                </tr>
                {{-- Steps to Reproduce --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Steps to Reproduce
                    </th>
                    <td class="w-full px-4 py-3">{{ $defect->def_steps_to_reproduce ?? '' }}</td>
                </tr>
                {{-- Expected Result --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Expected Result
                    </th>
                    <td class="w-full px-4 py-3">{{ $defect->def_expected_result ?? '' }}</td>
                </tr>
                {{-- Actual Result --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Actual Result
                    </th>
                    <td class="w-full px-4 py-3">{{ $defect->def_actual_result ?? '' }}</td>
                </tr>
                {{-- Defect Type --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Defect Type
                    </th>
                    <td class="w-full px-4 py-3 capitalize">
                        {{ $defect->def_type }}
                    </td>
                </tr>
                {{-- Defect Aging --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Aging
                    </th>
                    <td class="w-full px-4 py-3 capitalize">
                        {{ round($defect->created_at->diffInDays(now())) }}
                        {{ round($defect->created_at->diffInDays(now())) == 1 ? 'day' : 'days' }}
                    </td>
                </tr>
                {{-- Status --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Status
                    </th>
                    <td class="w-full px-4 py-3  capitalize">
                        {{ $defect->def_status ?? '' }}
                    </td>
                </tr>
                {{-- Severity --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Severity
                    </th>
                    <td class="w-full px-4 py-3 ">
                        @if ($defect->def_severity)
                            <span
                                class="{{ match ($defect->def_severity) {
                                    'minor' => 'text-green-500',
                                    'major' => 'text-yellow-500',
                                    'blocker' => 'text-red-500',
                                    default => 'text-gray-500',
                                } }}">
                                {{ ucfirst($defect->def_severity) }}
                            </span>
                        @else
                            <span class="text-gray-500">N/A</span>
                        @endif
                    </td>
                </tr>
                {{-- Priority --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Priority
                    </th>
                    <td class="w-full px-4 py-3">
                        @if ($defect->def_priority)
                            <span
                                class="{{ match ($defect->def_priority) {
                                    'low' => 'text-green-500',
                                    'medium' => 'text-yellow-500',
                                    'high' => 'text-red-500',
                                    default => 'text-gray-500',
                                } }}">
                                {{ ucfirst($defect->def_priority) }}
                            </span>
                        @else
                            <span class="text-gray-500">N/A</span>
                        @endif
                    </td>
                </tr>

                {{-- Created By --}}
                <tr class="border-b dark:border-gray-700">
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Test Engineer
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $defect->createdBy->username ?? '' }}
                    </td>
                </tr>
                {{-- Assigned To --}}
                <tr>
                    <th
                        class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium text-left sm:whitespace-nowrap">
                        Assigned To
                    </th>
                    <td class="w-full px-4 py-3">
                        {{ $defect->assignedTo->username ?? '' }}
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
                    @foreach ($defect->comments as $comment)
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
                @foreach ($defect_versions as $index => $previousVersion)
                    @if ($index === 0)
                        @continue
                    @endif

                    @php
                        $version = $index > 0 ? $defect_versions[intval($index) - 1] : null;
                    @endphp

                    <div class="bg-gray-100 dark:bg-gray-800 shadow-sm rounded-md px-4 py-3 transition-all duration-300"
                        x-data="{ showDetails: {{ $index === 1 ? 'true' : 'false' }} }">
                        <!-- Version Header -->
                        <div class="flex items-center justify-between text-gray-500 mb-3 cursor-pointer"
                            @click="showDetails = !showDetails">
                            <p>Modified by {{ $version->createdBy->name }}</p>
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
                            <!-- Defect ID -->
                            @if ($version->def_name !== $previousVersion->def_name)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Dfect ID',
                                    'current' => $version->def_name ?? 'None',
                                    'previous' => $previousVersion->def_name ?? 'None',
                                ])
                            @endif
                            <!-- Defect Description -->
                            @if ($version->def_description !== $previousVersion->def_description)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Description',
                                    'current' => $version->def_description ?? 'None',
                                    'previous' => $previousVersion->def_description ?? 'None',
                                ])
                            @endif
                            <!-- Build ID -->
                            @if ($version->build?->id !== $previousVersion->build?->id)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Build ID',
                                    'current' => $version->build->name ?? 'None',
                                    'previous' => $previousVersion->build->name ?? 'None',
                                ])
                            @endif
                            <!-- Module ID -->
                            @if ($version->module?->id !== $previousVersion->module?->id)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Module ID',
                                    'current' => $version->module->module_name ?? 'None',
                                    'previous' => $previousVersion->module->module_name ?? 'None',
                                ])
                            @endif

                            <!-- Requirement ID -->
                            @if ($version->requirement?->id !== $previousVersion->requirement?->id)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Requirement ID',
                                    'current' => $version->requirement->requirement_title ?? 'None',
                                    'previous' => $previousVersion->requirement->requirement_title ?? 'None',
                                ])
                            @endif
                            <!-- Test Scenario ID -->
                            @if ($version->testScenario?->id !== $previousVersion->testScenario?->id)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Test Scenario ID',
                                    'current' => $version->testScenario->ts_name ?? 'None',
                                    'previous' => $previousVersion->testScenario->ts_name ?? 'None',
                                ])
                            @endif
                            <!-- Test Case ID -->
                            @if ($version->testCase?->id !== $previousVersion->testCase?->id)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Test Case ID',
                                    'current' => $version->testCase->tc_name ?? 'None',
                                    'previous' => $previousVersion->testCase->tc_name ?? 'None',
                                ])
                            @endif
                            <!-- Defect Steps to Reproduce -->
                            @if ($version->def_steps_to_reproduce !== $previousVersion->def_steps_to_reproduce)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Steps to Reproduce',
                                    'current' => $version->def_steps_to_reproduce ?? 'None',
                                    'previous' => $previousVersion->def_steps_to_reproduce ?? 'None',
                                ])
                            @endif
                            <!-- Defect Expected Result -->
                            @if ($version->def_expected_result !== $previousVersion->def_expected_result)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Expected Result',
                                    'current' => $version->def_expected_result ?? 'None',
                                    'previous' => $previousVersion->def_expected_result ?? 'None',
                                ])
                            @endif
                            <!-- Defect Actual Result -->
                            @if ($version->def_actual_result !== $previousVersion->def_actual_result)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Actual Result',
                                    'current' => $version->def_actual_result ?? 'None',
                                    'previous' => $previousVersion->def_actual_result ?? 'None',
                                ])
                            @endif
                            <!-- Defect Type -->
                            @if ($version->def_type !== $previousVersion->def_type)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Defect Type',
                                    'current' => $version->def_type ?? 'None',
                                    'previous' => $previousVersion->def_type ?? 'None',
                                ])
                            @endif
                            <!-- Defect Status -->
                            @if ($version->def_status !== $previousVersion->def_status)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Status',
                                    'current' => $version->def_status ?? 'None',
                                    'previous' => $previousVersion->def_status ?? 'None',
                                ])
                            @endif
                            <!-- Defect Severity -->
                            @if ($version->def_severity !== $previousVersion->def_severity)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Severity',
                                    'current' => $version->def_severity ?? 'None',
                                    'previous' => $previousVersion->def_severity ?? 'None',
                                ])
                            @endif
                            <!-- Defect Priority -->
                            @if ($version->def_priority !== $previousVersion->def_priority)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Priority',
                                    'current' => $version->def_priority ?? 'None',
                                    'previous' => $previousVersion->def_priority ?? 'None',
                                ])
                            @endif
                            <!-- Assigned To -->
                            @if ($version->assignedTo?->id !== $previousVersion->assignedTo?->id)
                                @include('livewire.defect.partials.version-diff', [
                                    'field' => 'Assigned To',
                                    'current' => $version->assignedTo->username ?? 'None',
                                    'previous' => $previousVersion->assignedTo->username ?? 'None',
                                ])
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
