@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center w-full px-4 py-2 text-sm font-medium rounded-lg bg-indigo-600 text-white shadow-sm transition duration-200'
    : 'flex items-center w-full px-4 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-800 hover:text-indigo-600 transition duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
