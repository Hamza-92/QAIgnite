<div class="transition-colors duration-200">
    <div class="flex flex-col flex-wrap px-8 py-4 border-b dark:border-gray-700">
        <a href="{{ route('test-cases') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2"><i
                class="fa-solid fa-arrow-left"></i> Test Cases</a>
        <h2 class="text-lg font-medium mt-2">AI Test Case Generator</h2>
    </div>

    <!-- Main content area -->
    <div class="px-8 py-4">
        <div class="flex items-center mb-5">
            <div>
                <h2 class="text-lg font-bold">Generate New Test Cases</h2>
            </div>
        </div>

        <!-- Generation Form -->
        <form wire:submit.prevent="generate" class="space-y-5">
            <div>
                <label for="prompt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Requirement
                    Description</label>
                <x-textarea model="prompt" rows="4"
                    placeholder="Enter the test scenario or requirement (e.g., 'User login functionality')" />
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-info-circle mr-1"></i> Be specific but concise for best results.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                <button type="submit" @if ($latestGeneration && ($latestGeneration->status == 'pending' || $latestGeneration->status == 'processing')) disabled @endif
                    class="px-6 py-3 rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center
                    @if ($latestGeneration && ($latestGeneration->status == 'pending' || $latestGeneration->status == 'processing'))
                        bg-gray-400 text-gray-200 cursor-not-allowed
                    @else
                        bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white cursor-pointer
                    @endif">
                    <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>
                    Generate Test Cases
                </button>

                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-bolt mr-2 text-yellow-500"></i>
                    Powered by AI • Typically takes 20-60 seconds
                </div>
            </div>
        </form>

        <!-- Pending/Processing Status Modules -->
        @if ($latestGeneration && ($latestGeneration->status == 'pending' || $latestGeneration->status == 'processing'))
            <div wire:poll.3s class="mt-8 space-y-4">
                @if ($latestGeneration->status === 'pending')
                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <i class="fa-solid fa-hourglass-start text-gray-500 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200">Your Request is in Queue</h3>
                                <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    @php
                                        $secondsElapsed = $latestGeneration->updated_at->diffInSeconds(now());
                                        if ($secondsElapsed < 15) {
                                            echo "We're preparing your request...";
                                        } elseif ($secondsElapsed < 30) {
                                            echo 'Almost there! Your request will start soon.';
                                        } else {
                                            echo 'Taking longer than usual. We appreciate your patience.';
                                        }
                                    @endphp
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-500">
                                        <i class="fa-solid fa-clock mr-1"></i> Typically begins within 15-30 seconds
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($latestGeneration->status === 'processing')
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <i class="fa-solid fa-spinner fa-pulse text-blue-500 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Generating Test Cases</h3>
                                <div class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                                    @php
                                        $secondsElapsed = $latestGeneration->updated_at->diffInSeconds(now());
                                        if ($secondsElapsed < 10) {
                                            echo 'Analyzing your requirements...';
                                        } elseif ($secondsElapsed < 20) {
                                            echo 'Generating comprehensive test cases...';
                                        } elseif ($secondsElapsed < 40) {
                                            echo 'Finalizing test cases...';
                                        } elseif ($secondsElapsed < 60) {
                                            echo 'Taking longer than expected. Almost done!';
                                        } else {
                                            echo 'This is taking longer than expected. Please bear with us!';
                                        }
                                    @endphp
                                    <p class="mt-2 text-xs text-blue-600 dark:text-blue-400">
                                        <i class="fa-solid fa-lightbulb mr-1"></i> Typically completes within 20-60 seconds
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Completed/Failed Results Section -->
        @if ($latestGeneration && ($latestGeneration->status === 'completed' || $latestGeneration->status === 'failed'))
            <div class="mt-8 py-8 border-t dark:border-gray-700">
                <!-- Latest Result Header -->
                <div class="px-4 py-3 flex items-center justify-between gap-4 flex-wrap bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <i class="fa-solid fa-clock-rotate-left text-blue-500"></i>
                        </div>
                        <h2 class="font-bold text-lg text-gray-800 dark:text-gray-200">Latest Generation</h2>
                    </div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fa-solid fa-calendar-day mr-1"></i>
                        {{ $latestGeneration->created_at->format('M j, Y \a\t g:i A') }}
                    </span>
                </div>

                <!-- Generation Details -->
                <div class="mt-4 space-y-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prompt:</p>
                        <p class="text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 p-3 rounded">
                            {{ $latestGeneration->prompt }}</p>
                    </div>

                    <div class="flex items-center">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Status:</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if ($latestGeneration->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @elseif($latestGeneration->status === 'failed')
                                bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 @endif">
                            {{ ucfirst($latestGeneration->status) }}
                            @if ($latestGeneration->status === 'completed')
                                <i class="fa-solid fa-check-circle ml-1.5"></i>
                            @elseif($latestGeneration->status === 'failed')
                                <i class="fa-solid fa-circle-exclamation ml-1.5"></i>
                            @endif
                        </span>
                    </div>
                </div>

                @if ($latestGeneration->status === 'failed')
                    <div class="mt-6 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">We Hit a Snag</h3>
                                <div class="mt-1 text-sm text-red-700 dark:text-red-300">
                                    <p>
                                        Something unexpected interrupted our process...
                                    </p>
                                    @if ($latestGeneration->error_message)
                                        <div class="mt-2 p-2 bg-white dark:bg-gray-800 rounded text-red-600 dark:text-red-400 text-xs font-mono">
                                            {{ $latestGeneration->error_message }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <button wire:click="regenerate"
                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md font-medium transition-colors duration-150 flex items-center">
                                        <i class="fa-solid fa-arrows-rotate mr-2"></i>
                                        Try Again
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($latestGeneration->status === 'completed')
                    <div class="mt-6 space-y-4">
                        <!-- Bulk Actions -->
                        <div class="flex justify-between items-center flex-wrap gap-4 mb-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center flex-wrap gap-4">
                                <button wire:click="importAllTestCases"
                                    class="px-4 py-2 bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-500 text-white rounded-md font-medium transition-colors duration-150 flex items-center">
                                    <i class="fa-solid fa-download mr-2"></i>
                                    Import All
                                </button>
                                <button wire:click="importSelectedTestCases"
                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md font-medium transition-colors duration-150 flex items-center">
                                    <i class="fa-solid fa-download mr-2"></i>
                                    Import Selected ({{ count($selectedTestCases) }})
                                </button>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                <i class="fa-solid fa-bolt mr-1 text-yellow-500"></i>
                                Generated in
                                {{ $latestGeneration->created_at->diffInSeconds($latestGeneration->updated_at) ?? '?' }}
                                seconds
                            </div>
                        </div>

                        <!-- Test Cases List -->
                        <div class="space-y-3">
                            @foreach ($latestGeneration->response as $index => $testCase)
                                <div x-data="{ expanded: false }"
                                    class="border rounded-lg dark:border-gray-600 bg-white dark:bg-gray-800 overflow-hidden">
                                    <!-- Test Case Header -->
                                    <div class="flex items-center justify-between flex-wrap gap-4 p-4 border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                        <div class="flex-1 flex items-center space-x-4">
                                            <input type="checkbox" wire:model.live="selectedTestCases"
                                                value="{{ json_encode($testCase) }}"
                                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 cursor-pointer"
                                                @click.stop>
                                            <span class="font-bold text-gray-700 dark:text-gray-200 w-full"
                                                @click="expanded = !expanded">
                                                {{ $loop->iteration }} - {{ $testCase['id'] }}
                                            </span>
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <button wire:click="importTestCase({{ json_encode($testCase) }})"
                                                class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md text-sm font-medium transition-colors duration-150 flex items-center"
                                                @click.stop>
                                                <i class="fa-solid fa-download mr-1.5 text-xs"></i>
                                                Import
                                            </button>
                                            <button @click="expanded = !expanded"
                                                class="p-1.5 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                                <svg class="w-4 h-4 transform transition-transform duration-200"
                                                    :class="{ 'rotate-180': expanded }"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Always visible summary -->
                                    <div class="p-4">
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Summary</h4>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            {{ $testCase['summary'] }}</p>
                                    </div>

                                    <!-- Collapsible Content -->
                                    <div x-show="expanded" x-collapse class="p-4 pt-0 space-y-4">
                                        <!-- Steps -->
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                                <i class="fa-solid fa-list-ol mr-2 text-blue-500 text-xs"></i>
                                                Steps
                                            </h4>
                                            <div class="text-gray-600 dark:text-gray-400 text-sm space-y-2 ml-6 pl-2 border-l-2 border-gray-200 dark:border-gray-600">
                                                @foreach (explode("\n", $testCase['steps']) as $step)
                                                    @if (trim($step))
                                                        <div class="flex">
                                                            <span class="inline-block w-5 text-gray-400 dark:text-gray-500">{{ $loop->iteration }}.</span>
                                                            <span>{{ $step }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Expected Results -->
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                                <i class="fa-solid fa-clipboard-check mr-2 text-blue-500 text-xs"></i>
                                                Expected Results
                                            </h4>
                                            <div class="text-gray-600 dark:text-gray-400 text-sm space-y-2 ml-6 pl-2 border-l-2 border-gray-200 dark:border-gray-600">
                                                @foreach (explode("\n", $testCase['expected']) as $result)
                                                    @if (trim($result))
                                                        <div class="flex">
                                                            <span class="inline-block w-5 text-gray-400 dark:text-gray-500">{{ $loop->iteration }}.</span>
                                                            <span>{{ $result }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button wire:click="regenerate"
                                class="text-blue-500 hover:text-blue-600 dark:hover:text-blue-400 flex items-center transition-colors duration-150 cursor-pointer">
                                <i wire:loading wire:target='regenerate'
                                    class="fa-solid fa-arrows-rotate fa-spin mr-2"></i>
                                <span wire:loading.remove wire:target='regenerate'>
                                    <i class="fa-solid fa-arrows-rotate mr-2"></i>
                                </span>
                                Regenerate
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
