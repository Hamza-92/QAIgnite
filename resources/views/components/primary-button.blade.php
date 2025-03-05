<button type="{{ $type }}" id="{{ $model }}"
    @if (strlen($model) > 0 && $type != 'submit')
    wire:click="{{ $model }}"

    @endif
    class="px-4 py-2 rounded-md bg-blue-500 hover:bg-blue-600 text-gray-100 dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer {{ $class }}"
    {{ $attributes }}>
    {{ $slot }}
    <i wire:loading wire:target="{{ $model }}" class="fa-solid fa-spinner fa-spin"></i>
</button>
