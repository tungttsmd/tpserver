@props([
    'max' => '64px',
])

@php
    $baseClass = "px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[$max]";
@endphp

<th class="{{ $baseClass }}">
    {{ $slot }}
</th>
