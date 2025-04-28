<div class="flex flex-col gap-1 w-full {{ $class }}">
    <label>{{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <div class="relative">
        <select
        @if ($live)
        wire:model.live='{{ $model }}'
        @else
        wire:model='{{ $model }}'
        @endif
        name="{{ $model }}" id="{{ $model }}"
            class="appearance-none px-4 py-2 pr-8 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            {{ $slot }}
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
            <i @click="open_model = !open_model" wire:loading.remove wire:target='{{ $model }}' class="fa-solid fa-angle-down"
                ></i>
            <i wire:loading wire:target='{{ $model }}' class="fa-solid fa-spinner fa-spin"></i>
        </div>
    </div>
    @error($model)
        <span class="text-red-500">{{ $message }}</span>
    @enderror
</div>
