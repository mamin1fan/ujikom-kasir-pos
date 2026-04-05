@props(['label', 'icon', 'badge' => null])
@php $paths = explode('|', $icon); @endphp
<div
    class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-400 dark:text-gray-600 cursor-not-allowed opacity-60 mb-px">
    <svg class="w-4 h-4 flex-shrink-0 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        @foreach($paths as $path)
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}" />
        @endforeach
    </svg>
    {{ $label }}
    @if($badge)
        <span
            class="ml-auto text-xs bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 px-2 py-0.5 rounded-full border border-gray-200 dark:border-gray-700">{{ $badge }}</span>
    @endif
</div>