@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2 gap-2 font-medium rounded-lg bg-blue-500 text-white dark:text-gray-300 dark:bg-blue-600 focus:outline-none focus:border-blue-600 transition duration-150 ease-in-out'
            : 'flex items-center px-4 py-2 gap-2 font-medium rounded-lg focus:outline-none focus:border-white focus:text-blue-600 hover:bg-blue-500 hover:text-white dark:hover:bg-blue-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
