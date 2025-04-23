<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">AI Test Case Generator</h2>

    <textarea wire:model="scenario" class="w-full border p-2 mb-4" rows="4" placeholder="Enter your test scenario..."></textarea>

    <button wire:click="generateTestCases"
            class="bg-blue-500 text-white px-4 py-2 rounded"
            wire:loading.attr="disabled">
        Generate
    </button>

    <div wire:loading class="text-gray-600 mt-2">Generating...</div>

    @if ($result)
        <h3 class="mt-6 font-semibold">Generated Test Cases:</h3>
        <pre class="mt-2 p-4 bg-gray-100 rounded whitespace-pre-wrap">{{ $result }}</pre>
    @endif
</div>
