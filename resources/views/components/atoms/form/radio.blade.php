@props(['options' => collect([]), 'key', 'value', 'keyDefault' => -1, 'live' => ''])

@php
    $name = $live . '-' . $key;
@endphp

@foreach ($options->pluck($value, $key) as $id => $label)
    <div class="flex items-center gap-2">
        <input wire:model.defer="{{ $live }}" value="{{ $id }}" type="radio" name="{{ $name }}"
            id="{{ $name . '-' . $id }}" @if ($id === $keyDefault) checked @endif>
        <label for="{{ $name . '-' . $id }}">{{ $label }}</label>
    </div>
@endforeach
