<div class="flex flex-col gap-2 w-full {{ $class }}" $attributes>
    <label>
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <div x-data='{open_model : false}' @click.outside="open_model = false" @close.stop="open_model = false"
        class="relative">

        {{-- Content Box --}}
        <div @click="open_model = !open_model" class="flex items-center px-4 py-2 rounded-md border border-gray-200 dark:border-gray-700">

            <div class="w-full flex items-center justify-between">
                <span>
                    {{ $selected_option }}
                </span>
                <button x-show="{{ $selected_option ? 'true' : 'false' }}" @click="open_model = false" class="px-1" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <i :class="{ 'fa-angle-down': !open_model, 'fa-angle-up': open_model }"
                class="fa-solid ml-2 text-gray-500"></i>
        </div>

        {{-- Dropdown --}}
        <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-10 mt-2 w-full rounded-md shadow-lg bg-gray-100 dark:bg-gray-800 max-h-72 overflow-auto">
            <div class="border-b dark:border-gray-700">
                <input wire:model.live.debounce.300='{{ $search }}' type="text"
                    class="w-full px-4 py-3 text-sm dark:bg-gray-800 outline-none focus:outline-none border-none focus:border-none focus:ring-none"
                    placeholder="Type to search">
            </div>
            <div>
                @forelse ($options as $option)
                    <button wire:key='{{ $option->id }}' id="{{ $option->id }}" type="button"
                        {{ $option_attributes }} @click = 'open_model = false'
                        class="py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                        {{ $option->name }}
                    </button>
                @empty
                    <p
                        class="py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                        No records found</p>
                @endforelse
            </div>
        </div>

        {{-- Error --}}
        @error($model)
            <span class="text-red-500">{{ $message }}</span>
        @enderror
    </div>
</div>
