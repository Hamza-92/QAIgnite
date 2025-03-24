@props([
    'class' => '',
    'label' => 'Select Option',
    'required' => false,
    'options' => [],
    'selectedOption' => null,
    'model' => null,
])

<div class="flex flex-col gap-2 w-full {{ $class }}">
    <label>
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
        <!-- Content Box -->
        <div @click="open = !open"
            class="flex items-center px-4 py-2 rounded-md border border-gray-200 dark:border-gray-700 cursor-pointer">
            <span class="w-full">{{ $selectedOption ?? 'Select an option' }}</span>
            <button x-show="{{ $selectedOption ? 'true' : 'false' }}" @click="$wire.set('selectedOption', null); open = false;" type="button">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <i :class="{ 'fa-angle-down': !open, 'fa-angle-up': open }" class="fa-solid ml-2 text-gray-500"></i>
        </div>

        <!-- Dropdown -->
        <div x-show="open" x-transition class="absolute z-10 mt-2 w-full rounded-md shadow-lg bg-gray-100 dark:bg-gray-800 max-h-72 overflow-auto">
            <div class="border-b dark:border-gray-700">
                <input wire:model.debounce.300ms="search" type="text"
                    class="w-full px-4 py-3 text-sm dark:bg-gray-800 outline-none" placeholder="Type to search">
            </div>
            <div>
                @forelse ($options as $option)
                    <button wire:click="selectOption('{{ $option['id'] }}')" type="button"
                        class="py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                        {{ $option['name'] }}
                    </button>
                @empty
                    <p class="py-3 px-4 bg-white dark:bg-gray-800 text-left w-full">
                        No records found
                    </p>
                @endforelse
            </div>
        </div>

        <!-- Error -->
        @error($model)
            <span class="text-red-500">{{ $message }}</span>
        @enderror
    </div>
</div>
