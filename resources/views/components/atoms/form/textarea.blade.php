@props([
    'label' => '',
    'formId' => '',
    'livewireId' => '',
    'class' => 'w-full flex flex-col gap-0 ', // Additional classes can be passed via the component's attributes
    'classInput' => 'w-full border rounded ', // Additional classes can be passed via the component's attributes
    'classLabel' => '', // Additional classes can be passed via the component's attributes
    'border' => false,
])
@php
    $border = filter_var($border, FILTER_VALIDATE_BOOLEAN);
@endphp
<div {{ $attributes->merge(['class' => $class]) }}>
    @if ($label)
        <label for="{{ $formId }}" {{ $attributes->merge(['class' => $classLabel]) }}>{{ $label }}</label>
    @endif
    <textarea wire:model.defer="{{ $livewireId }}" id="{{ $formId }}"
        {{ $attributes->merge(['class' => $classInput]) }}>
</textarea>
</div>
