@props([
    'header' => '--',
    'sort' => null,
    'dir' => null,
    'class' => '',
])

<th class="px-6 py-3 text-left text-sm font-medium text-gray-500 whitespace-nowrap {{ $class }}"
    title="{{ $header }}">
    <button wire:click="sortBy('{{ $header }}')" class="text-left">
        @if ($sort === $header)
            <span>{{ $dir === 'asc' ? '↑' : '↓' }}</span>
        @endif
        {{ $header }}
    </button>
</th>
