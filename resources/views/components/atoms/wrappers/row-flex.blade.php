@props([
    'class' => '', // thêm class tuỳ chỉnh
])
<div {{ $attributes->merge(['class' => 'flex whitespace-nowrap overflow-x-auto gap-2 ' . $class]) }}>
    {{ $slot }}
</div>
