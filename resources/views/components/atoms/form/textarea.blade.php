@props([
    'formId' => '',
    'livewireId' => '',
    'class' => '', // Additional classes can be passed via the component's attributes
])
<textarea wire:model.defer="{{ $livewireId }}" id="{{ $formId }}"
    {{ $attributes->merge(['class' => 'w-full' . $class]) }}>
</textarea>
