@props([
    'class' => '', // thêm class tuỳ ý khi gọi component
    'classLabel' => '', // thêm class tuỳ ý cho label khi gọi component
    'classInput' => '', // thêm class tuỳ ý cho label khi gọi component
    'defer' => true, // mặc định là realtime, nếu muốn defer thì truyền defer=true
    'required' => false, // có dấu * nếu là trường bắt buộcs
    'formId' => '',
    'livewireId' => '',
    'type' => 'text',
    'label' => 'defer input',
])

@php
    $defer = filter_var($defer, FILTER_VALIDATE_BOOLEAN);
@endphp

<div class="{{ $class }}">
    <label for="{{ $formId }}" {{ $attributes->merge(['class' => 'pr-2 ' . $classLabel]) }}>
        {{ $label }}
        @if ($required)
            <span>* </span>
        @endif
    </label>

    <input type="{{ $type }}" id="{{ $formId }}"
        @if ($defer) wire:model.defer="{{ $livewireId }}" @else wire:model="{{ $livewireId }}" @endif
        {{ $attributes->merge(['class' => $classInput]) }}>
</div>
