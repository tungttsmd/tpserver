@props([
    'livewireId' => '',
    'defer' => true,
    'class' => '', // Additional classes can be passed via the component's attributes
    'label' => 'checkbox',
    'formId' => '',
    'name' => '',
    'classCheckbox' => '', // Additional classes can be passed via the component's attributes
    'classLabel' => '', // Additional classes can be passed via the component's attributes
])
<div {{ $attributes->merge(['class' => 'flex w-full ' . $class]) }}>
    <input
        @if ($defer) wire:model.defer="{{ $livewireId }}" @else wire:model="{{ $livewireId }}" @endif
        type="checkbox" id="{{ $formId }}" {{ $attributes->merge(['class' => 'w-m-[40px] ' . $classCheckbox]) }}>
    <label for="{{ $formId }}" {{ $attributes->merge(['class' => 'w-full pl-2 ' . $classLabel]) }}>
        {{ $label }}
    </label>
</div>
