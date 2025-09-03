@props([
    'livewireId' => '',
    'list' => [], // Mảng ['a'=>'b'] hoặc là một collection {a:b}
    'class' => '',
    'title' => 'dropdown',
    'icon' => 'refresh',
    'default' => 'Tất cả',
    'item' => 'id',
])

<div {{ $attributes->merge(['class' => 'w-full flex justify-between items-center gap-2 ' . $class]) }}>
    <label>{{ $title }}</label>
    <select wire:model="{{ $livewireId }}" class="{{ $class }}">
        <option value="">{{ $default }}</option>
        @foreach ($list as $key => $value)
            @if (is_array($list))
                <option value="{{ $key }}">{{ $value }}</option>
            @else
                <option value="{{ $key }}">{{ data_get($value, $item) }}</option>
            @endif
        @endforeach
    </select>
</div>
