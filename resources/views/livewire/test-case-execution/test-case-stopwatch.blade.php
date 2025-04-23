<div class="p-4 bg-white shadow rounded" wire:poll.1s>
    <div class="text-2xl font-semibold mb-2">
        ⏱ {{ $formatted }}
    </div>

    @if (!$running && !$session->started_at)
        <button wire:click="start" type="button" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Start</button>
    @elseif ($running)
        <button wire:click="pause" type="button" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Pause</button>
    @else
        <button wire:click="resume" type="button" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Resume</button>
    @endif
</div>
