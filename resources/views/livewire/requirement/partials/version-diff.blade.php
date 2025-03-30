@if($current !== null)
<div class="w-full">
    <h4 class="font-medium">{{ $field }}</h4>
    <div class="mt-1 border dark:border-gray-700 rounded-sm flex flex-col sm:flex-row items-center">
        <div class="flex-1 px-4 py-2">
            @if(isset($isAttachment) && $isAttachment)
                @if($previous !== 'None')
                    @foreach(explode(', ', $previous) as $file)
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $file }}</div>
                    @endforeach
                @else
                    {{ $previous }}
                @endif
            @else
                {{ $previous ?? 'None' }}
            @endif
        </div>
        <span
            x-data="{ isSmallScreen: window.innerWidth < 640 }"
            x-init="window.addEventListener('resize', () => isSmallScreen = window.innerWidth < 640)"
            :class="isSmallScreen ? 'rotate-90 sm:rotate-0' : ''"
            class="px-4 py-2 border-l sm:border-l sm:border-r border-t sm:border-t-0 dark:border-gray-700">
            <i class="fa-solid fa-arrow-right"></i>
        </span>
        <div class="flex-1 px-4 py-2">
            @if(isset($isAttachment) && $isAttachment)
                @foreach(explode(', ', $current) as $file)
                    <div class="text-sm">{{ $file }}</div>
                @endforeach
            @else
                <span class="{{ $current === 'None' ? 'text-red-500' : '' }}">
                    {{ $current }}
                </span>
            @endif
        </div>
    </div>
</div>
@endif
