@props([
    'wire' => '',
    'list' => [], // Mảng ['a'=>'b'] hoặc là một collection {a:b}
    'class' => '',
    'title' => 'Chọn lựa',
    'icon' => 'refresh',
    'default' => 'Tất cả',
    'item' => 'id',
])

<div class="filament-forms-select-component w-full max-w-sm {{ $class }}">
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $title }}</label>
    <select wire:model="{{ $wire }}"
        class="filament-forms-select-input block w-full md:min-w-[150px] rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm py-2 pl-2 {{ $class }}">
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
