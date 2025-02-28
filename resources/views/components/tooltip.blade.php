<div x-data="{ tooltip: false }" class="relative inline-block">
    <!-- Tooltip Trigger -->
    <span @mouseenter="tooltip = true" @mouseleave="tooltip = false" class="cursor-pointer">
        {{ $slot }}
    </span>

    <!-- Tooltip Box -->
    <div x-show="tooltip" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="absolute z-50 text-sm px-3 py-2 rounded-lg shadow-lg max-w-xs whitespace-nowrap
               bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700"
        :class="{
            'left-1/2 transform -translate-x-1/2 -top-12': '{{ $position }}' === 'top',
            'left-1/2 transform -translate-x-1/2 top-8': '{{ $position }}' === 'bottom',
            'right-full top-1/2 transform -translate-y-1/2 -mr-2': '{{ $position }}' === 'left',
            'left-full top-1/2 transform -translate-y-1/2 ml-2': '{{ $position }}' === 'right',
        }">
        {{ $message }}

        <!-- Tooltip Arrow -->
        <span class="absolute w-2 h-2 transform rotate-45 bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"
            :class="{
                'top-full left-1/2 -translate-x-1/2 mt-[-4px]': '{{ $position }}' === 'top',
                'bottom-full left-1/2 -translate-x-1/2 mb-[-4px]': '{{ $position }}' === 'bottom',
                'top-1/2 left-full -translate-y-1/2 ml-[-4px]': '{{ $position }}' === 'left',
                'top-1/2 right-full -translate-y-1/2 mr-[-4px]': '{{ $position }}' === 'right',
            }">
        </span>
    </div>
</div>
