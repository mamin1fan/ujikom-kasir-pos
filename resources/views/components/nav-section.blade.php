@props(['label' => null, 'items' => []])
<div class="mb-1">
    @if($label)
        <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wide px-3 py-2">{{ $label }}</p>
    @endif
    @foreach($items as $item)
        @php
            $active = request()->routeIs($item['match']);
            $href = isset($item['params'])
                ? route($item['route'], $item['params'])
                : route($item['route']);
            $paths = explode('|', $item['icon']);
        @endphp
        <a href="{{ $href }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors mb-px
                       {{ $active
            ? 'bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 font-medium'
            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <svg class="w-4 h-4 flex-shrink-0 {{ $active ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @foreach($paths as $path)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}" />
                @endforeach
            </svg>
            {{ $item['label'] }}
        </a>
    @endforeach
</div>