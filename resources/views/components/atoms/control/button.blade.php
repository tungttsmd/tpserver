@props([
    'class' => '',
    'livewireId' => '',
    'title' => 'button',
])
<button wire:click="{{ $livewireId }}" type="button" title="{{ $title }}" 
    {{$attributes->merge(['class' => ''.$class])}}> 
    {{ $title }}
</button>
