<div class="relative flex items-center border rounded-md dark:border-gray-700" title="Click to search">
    <label for="{{$search}}" class="absolute inset-y-0 left-0 flex items-center pl-3 cursor-text">
        <i wire:loading.remove wire:target='{{$search}}' class="fa-solid fa-magnifying-glass text-gray-500"></i>
        <i wire:loading wire:target='{{$search}}' class="fa-solid fa-spinner fa-spin text-gray-500"></i>
    </label>
    <input id="{{$search}}" wire:model.live.debounce.300='{{$search}}'
        class="pl-10 pr-3 py-2 w-full rounded-md text-sm dark:bg-gray-900"
        type="text" placeholder="{{$placeholder}}">
    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
        <i wire:loading.remove wire:target='{{$resetMethod}}' x-show='$wire.{{$search}}.length > 0' class="fa-solid fa-xmark cursor-pointer"
            wire:click='{{$resetMethod}}'></i>
            <i wire:loading wire:target='{{$resetMethod}}' class="fa-solid fa-spinner fa-spin"></i>
    </span>
</div>
