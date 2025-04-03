<div class="w-full">
    <div class="px-8 py-4 border-b dark:border-gray-700">
        <a href="{{ route('requirements') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2"><i
                class="fa-solid fa-arrow-left"></i> Requirements</a>
        <h2 class="text-lg font-medium mt-2">{{ $requirement->requirement_title }}</h2>
    </div>

    <div class="p-8 w-full">
        <div class="border dark:border-gray-700">
            <table>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Build ID
                    </th>
                    <td class="w-full px-4 py-3">{{ $requirement->build->name ?? '' }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Module
                    </th>
                    <td class="w-full px-4 py-3">{{ $requirement->module->module_name ?? '' }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Requirement Title</th>
                    <td class="w-full px-4 py-3">{{ $requirement->requirement_title }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Requirement Source</th>
                    <td class="w-full px-4 py-3">{{ $requirement->requirement_source }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Requirement Type</th>
                    <td class="w-full px-4 py-3">{{ $requirement->requirement_type }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Test
                        Scenarios</th>
                    <td class="w-full px-4 py-3">
                        @if ($requirement->testScenarios->isNotEmpty())
                            <ul class="">
                                @foreach ($requirement->testScenarios as $scenario)
                                    <li>
                                        <a href="{{ route('test-scenario.detail', $scenario->id) }}" class="underline">
                                            {{ $scenario->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Test
                        Cases</th>
                    <td class="w-full px-4 py-3"></td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Defects
                    </th>
                    <td class="w-full px-4 py-3"></td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Status
                    </th>
                    <td class="w-full px-4 py-3">{{ $requirement->status }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Assigned To</th>
                    <td class="w-full px-4 py-3">{{ $requirement->assigned_to->username ?? '' }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Requirement Summary</th>
                    <td class="w-full px-4 py-3">{{ $requirement->requirement_summary }}</td>
                </tr>
            </table>
        </div>
        {{-- Attachments Viewer --}}
        <div x-data="{ open_model: false }" class="w-full mt-8">
            <!-- Toggle Button with Animation -->
            <div @click="open_model = !open_model"
                class="w-full flex items-center justify-between px-4 py-2 cursor-pointer text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300 rounded-t-lg"
                :class="{ 'rounded-lg': !open_model }">
                <h3 class="text-lg font-medium">Attachments ({{ count($attachments) }})</h3>
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
                <h3 class="text-lg font-medium">Comments ({{ count($requirement->comments) }})</h3>
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
                    @foreach ($requirement->comments as $comment)
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
                <div class="border-t dark:border-gray-700 pt-4 mt-2">
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
                @foreach ($requirement_versions as $index => $version)
                    @php
                        $previousVersion = $index > 0 ? $requirement_versions[$index - 1] : null;
                    @endphp

                    <div class="bg-gray-100 dark:bg-gray-800 shadow-sm rounded-md px-4 py-3 transition-all duration-300"
                        x-data="{ showDetails: {{ $index === 0 ? 'true' : 'false' }} }">
                        <!-- Version Header -->
                        <div class="flex items-center justify-between text-gray-500 mb-3 cursor-pointer"
                            @click="showDetails = !showDetails">
                            <p>Modified by {{ $version->createdBy->name }}</p>
                            <div class="flex items-center gap-3">
                                <p class="font-semibold">Version {{ $loop->iteration }}</p>
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
                            @if (!$previousVersion || $version->build?->id !== $previousVersion->build?->id)
                                @include('livewire.requirement.partials.version-diff', [
                                    'field' => 'Build ID',
                                    'current' => $version->build->name ?? 'None',
                                    'previous' => $previousVersion->build->name ?? 'None',
                                ])
                            @endif

                            <!-- Module -->
                            @if (!$previousVersion || $version->module?->id !== $previousVersion->module?->id)
                                @include('livewire.requirement.partials.version-diff', [
                                    'field' => 'Module',
                                    'current' => $version->module->module_name ?? 'None',
                                    'previous' => $previousVersion->module->module_name ?? 'None',
                                ])
                            @endif

                            <!-- Requirement Title -->
                            @if (!$previousVersion || $version->requirement_title !== $previousVersion->requirement_title)
                                @include('livewire.requirement.partials.version-diff', [
                                    'field' => 'Requirement Title',
                                    'current' => $version->requirement_title ?? 'None',
                                    'previous' => $previousVersion->requirement_title ?? 'None',
                                ])
                            @endif

                            <!-- Requirement Summary -->
                            @if (!$previousVersion || $version->requirement_summary !== $previousVersion->requirement_summary)
                                @include('livewire.requirement.partials.version-diff', [
                                    'field' => 'Requirement Summary',
                                    'current' => $version->requirement_summary ?? 'None',
                                    'previous' => $previousVersion->requirement_summary ?? 'None',
                                ])
                            @endif

                            <!-- Requirement Source -->
                            @if (!$previousVersion || $version->requirement_source !== $previousVersion->requirement_source)
                                @include('livewire.requirement.partials.version-diff', [
                                    'field' => 'Requirement Source',
                                    'current' => $version->requirement_source ?? 'None',
                                    'previous' => $previousVersion->requirement_source ?? 'None',
                                ])
                            @endif

                            <!-- Requirement Type -->
                            @if (!$previousVersion || $version->requirement_type !== $previousVersion->requirement_type)
                                @include('livewire.requirement.partials.version-diff', [
                                    'field' => 'Requirement Type',
                                    'current' => $version->requirement_type ?? 'None',
                                    'previous' => $previousVersion->requirement_type ?? 'None',
                                ])
                            @endif

                            <!-- Status -->
                            @if (!$previousVersion || $version->status !== $previousVersion->status)
                                @include('livewire.requirement.partials.version-diff', [
                                    'field' => 'Status',
                                    'current' => $version->status ?? 'None',
                                    'previous' => $previousVersion->status ?? 'None',
                                ])
                            @endif

                            <!-- Assigned To -->
                            @if (!$previousVersion || $version->assignedTo?->id !== $previousVersion->assignedTo?->id)
                                @include('livewire.requirement.partials.version-diff', [
                                    'field' => 'Assigned To',
                                    'current' => $version->assignedTo->username ?? 'None',
                                    'previous' => $previousVersion->assignedTo->username ?? 'None',
                                ])
                            @endif

                            <!-- Attachments -->
                            @if ($version->attachments && (!$previousVersion || $version->attachments != $previousVersion->attachments))
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

                                @include('livewire.requirement.partials.version-diff', [
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


    {{-- {{$requirement}} --}}
</div>
