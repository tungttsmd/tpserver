@props([
    'wire' => '',
    'class' => '',
    'title' => 'Tìm kiếm',
    'icon' => 'search',
    'placeholder' => 'Tìm kiếm...',
])

<div class="relative" title="{{ $title }}">
    <input wire:model.debounce="{{ $wire }}" type="text" placeholder="{{ $placeholder }}"
        class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 text-sm placeholder-gray-400
           focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none focus:ring-opacity-50" />
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
        <!-- Icon tìm kiếm (magnifying glass) -->
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-4 h-4 mr-1" />
    </div>
</div>
