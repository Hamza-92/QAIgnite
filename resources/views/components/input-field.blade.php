<div class="flex flex-col gap-1 w-full {{ $class }}">
    <label>{{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <input wire:model='{{ $model }}' type="{{ $type }}" name="{{ $model }}" id="{{ $model }}"
        placeholder="{{ $placeholder }}" class="px-4 py-2 rounded-md border border-gray-200 dark:border-gray-700">
    @error($model)
        <span class="text-red-500">{{ $message }}</span>
    @enderror
</div>
