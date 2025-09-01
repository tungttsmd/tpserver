@props([
    'label' => 'select',
    'livewireId' => '',
    'collection' => collect(),
    'itemId' => '',
    'itemName' => '',
    'formId' => '',
    'class' => '', // Additional classes can be passed via the component's attributes
])
<div {{ $attributes->merge(['class' => 'w-full flex justify-between items-center gap-2 ' . $class]) }}>
    <label for="{{ $formId }}">{{ $label }}</label>
    <select wire:model.defer="{{ $livewireId }}" required>
        <option value="">-- Chọn {{ strtolower($label) }} --</option>
        @foreach ($collection as $item)
            <option value="{{ $item->$itemId }}">{{ $item->$itemName }}</option>
        @endforeach
    </select>
</div>
