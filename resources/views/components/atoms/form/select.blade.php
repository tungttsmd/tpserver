@props([
    'label' => 'select',
    'livewireId' => '',
    'collection' => collect(),
    'itemId' => 'id',
    'itemName' => 'name',
    'formId' => '',
    'class' => '', // Additional classes can be passed via the component's attributes
    'classInput' => '',
    'classLabel' => '',
    'defer' => false,
])
@php
    $defer = filter_var($defer, FILTER_VALIDATE_BOOLEAN);
@endphp

<div {{ $attributes->merge(['class' => 'w-full flex justify-between items-center gap-2 ' . $class]) }}>
    <label for="{{ $formId }}" {{ $attributes->merge(['class' => $classLabel]) }}>{{ $label }}</label>
    <select {{ $attributes->merge(['class' => $classInput]) }}
        @if ($defer) wire:model.defer="{{ $livewireId }}" 
        @else wire:model="{{ $livewireId }}" @endif
        name="{{ $formId }}">
        <option value="">-- Chọn {{ strtolower($label) }} --</option>
        @foreach ($collection as $item)
            <option value="{{ $item->$itemId }}">{{ $item->$itemName }}</option>
        @endforeach
    </select>
</div>
