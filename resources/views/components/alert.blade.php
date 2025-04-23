@props(['type' => 'info', 'message' => ''])

@php
    $styles = [
        'success' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
        'error' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
        'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
    ];

    $icons = [
        'success' => 'fa-solid fa-circle-check',
        'warning' => 'fa-solid fa-triangle-exclamation',
        'error' => 'fa-solid fa-circle-xmark',
        'info' => 'fa-solid fa-circle-info',
    ];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition.duration.300ms
    class="flex items-start gap-3 p-4 mb-4 text-sm font-medium rounded-md shadow-sm {{ $styles[$type] }}"
    role="alert"
>
    <!-- Icon -->
    <i class="{{ $icons[$type] }} text-lg mt-0.5 shrink-0"></i>

    <!-- Message -->
    <div class="flex-1">
        {{ $message }}
    </div>

    <!-- Dismiss Button -->
    <button type="button" @click="show = false" class="text-inherit hover:opacity-70 cursor-pointer">
        <i class="fa-solid fa-xmark mt-0.5"></i>
    </button>
</div>
