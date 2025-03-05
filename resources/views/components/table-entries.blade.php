<div class="flex gap-2 items-center {{$class}}">
    <p>Show</p>

    <div class="relative">
        <select wire:model.live="{{ $entries }}"
            class="h-9 py-1 pl-3 pr-8 text-sm rounded-md border dark:bg-gray-900 dark:border-gray-700 appearance-none">
            @foreach ([20, 50, 100, 500] as $size)
                <option value="{{ $size }}">{{ $size }}</option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <svg wire:loading.remove wire:target="{{ $entries }}" class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
            </svg>
            <i wire:loading wire:target="{{ $entries }}" class="fa-solid fa-spinner fa-spin"></i>
        </div>
    </div>

    <p>entries</p>
</div>
