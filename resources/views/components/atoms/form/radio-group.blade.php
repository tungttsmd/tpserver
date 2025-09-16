@props([
    'name' => '',
    'options' => [],
    'selected' => null,
    'label' => null,
    'inline' => false,
    'id' => null,
])

@php
    $id = $id ?? $name . '_' . uniqid();
    $options = is_array($options) ? $options : $options->toArray();
    $inlineClass = $inline ? 'form-check-inline' : '';
@endphp

@if($label)
    <label class="form-label">{{ $label }}</label>
@endif

@foreach($options as $value => $label)
    @php
        $optionId = $id . '_' . $value;
        $isChecked = $selected == $value;
    @endphp
    <div class="form-check {{ $inlineClass }} mb-2">
        <input 
            type="radio" 
            name="{{ $name }}" 
            id="{{ $optionId }}" 
            value="{{ $value }}" 
            {{ $attributes->merge(['class' => 'form-check-input' . ($errors->has($name) ? ' is-invalid' : '')]) }}
            @if($isChecked) checked @endif
        >
        <label class="form-check-label" for="{{ $optionId }}">
            {{ $label }}
        </label>
    </div>
@endforeach

@error($name)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
@enderror
