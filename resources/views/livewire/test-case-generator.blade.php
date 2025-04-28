<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Test Case Generator</h1>

    <form wire:submit.prevent="generateTestCases" class="mb-6">
        <div class="mb-4">
            <label for="scenario" class="block text-sm font-medium text-gray-700 mb-1">
                Scenario Description
            </label>
            <textarea
                wire:model="scenario"
                id="scenario"
                rows="5"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Enter your test scenario here..."
                required
            ></textarea>
        </div>

        <button
            type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Generate Test Cases</span>
            <span wire:loading>
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Generating...
            </span>
        </button>
    </form>

    @if(isset($result))
        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-2">Generated Test Case</h2>

            @if(is_string($result))
                {{-- Simple string response --}}
                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-md whitespace-pre-wrap">{{ $result }}</div>
            @elseif(is_array($result) && isset($result['choices']))
                {{-- API response format --}}
                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-md whitespace-pre-wrap">
                    {{ $result['choices'][0]['message']['content'] ?? 'No test cases generated' }}
                </div>
            @elseif(is_array($result))
                {{-- Raw array output (for debugging) --}}
                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-md">
                    <pre>{{ json_encode($result, JSON_PRETTY_PRINT) }}</pre>
                </div>
            @endif

            @if($errors->any())
                <div class="mt-4 text-red-600">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>
