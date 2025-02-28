<div class="flex gap-2 items-center">
    <p>Show</p>

    <select wire:model.live="{{ $entries }}"
        class="h-8 py-1 text-sm rounded-md border border-gray-300 dark:bg-gray-900 dark:border-gray-700">

        @foreach ([20, 50, 100, 500] as $size)
            <option value="{{ $size }}">{{ $size }}</option>
        @endforeach

    </select>

    <p>entries</p>

    <i wire:loading wire:target="perPage" class="fa-solid fa-spinner fa-spin text-primary"></i>
</div>
