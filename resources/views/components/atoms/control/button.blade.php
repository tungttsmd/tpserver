@props([
    'wire' => '',
    'class' => '',
    'title' => 'Nút bấm',
    'icon' => 'refresh',
])
<button wire:click="{{ $wire }}" type="button" title="{{ $title }}"
    class="filament-button flex whitespace-nowrap items-center {{ $class }}">
    <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-4 h-4 mr-1" />
    {{ $title }}
</button>
