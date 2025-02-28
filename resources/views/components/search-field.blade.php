<div class="relative flex items-center">
    <span class="absolute h-full top-0 left-0 flex items-center justify-between px-3">
        <i wire:loading.remove wire:target='{{$search}}' class="fa-solid fa-magnifying-glass"></i>
        <i wire:loading wire:target='{{$search}}' class="fa-solid fa-spinner fa-spin"></i>
    </span>
    <input wire:model.live.debounce.300='{{$search}}'
        class="pl-8 border-gray-200 rounded-md text-sm dark:bg-gray-900 dark:border-gray-700" type="text"
        placeholder="{{$placeholder}}">
    <span class="absolute h-full top-0 right-0 flex items-center justify-between px-3">
        <i x-show='$wire.{{$search}}.length > 0' class="fa-solid fa-xmark cursor-pointer"
            wire:click='{{$resetMethod}}'></i>
    </span>
</div>
