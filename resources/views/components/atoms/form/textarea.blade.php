@props([
    'label' => '',
    'formId' => '',
    'livewireId' => '',
    'class' => '', // Additional classes can be passed via the component's attributes
    'border' => false,
])
@php
    $border = filter_var($border, FILTER_VALIDATE_BOOLEAN);
@endphp
@if ($border)
    <div class="border rounded">
@endif
@if($label)
<label for="{{ $formId }}">{{ $label }}</label>
@endif
<textarea wire:model.defer="{{ $livewireId }}" id="{{ $formId }}"
    {{ $attributes->merge(['class' => 'w-full' . $class]) }}>
</textarea>
@if ($border)
    </div>
@endif
