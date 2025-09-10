@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'checked' => false,
    'wireModel' => '',
    'id' => null,
    'disabled' => false,
    'class' => '',
    'labelClass' => 'text-sm font-medium text-gray-700',
    'wrapperClass' => 'flex items-start',
])

@php
    $id = $id ?? $name . '_' . $value;
    $wireModel = $wireModel ? 'wire:model.' . $wireModel : '';
@endphp

<div class="{{ $wrapperClass }}">
    <div class="flex items-center h-5">
        <input 
            type="checkbox" 
            id="{{ $id }}" 
            name="{{ $name }}[]"
            value="{{ $value }}"
            {{ $attributes->merge(['class' => 'focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded ' . $class]) }}
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $wireModel }}
        >
    </div>
    @if($label)
        <div class="ml-3 text-sm">
            <label for="{{ $id }}" class="{{ $labelClass }}">
                {{ $label }}
            </label>
        </div>
    @endif
</div>
