@props([
    'title' => '',
    'max' => '80px',
    'class' => '',
])

@php
    $baseClass = "px-3 py-2 bg-danger-subtle-light text-danger-subtle text-danger-subtle text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[$max]";
@endphp

<td title="{{ $title }}" class="x-td {{ $baseClass }} {{ $class }}">
    {{ $slot }}
</td>
