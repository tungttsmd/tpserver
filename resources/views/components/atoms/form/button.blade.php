@props([
    'class' => '', // Additional classes can be passed via the component's attributes
    'label' => 'button',
    'href' => null,
])
<button
    {{ $attributes->merge([
        'class' => $class,
        'type' => 'button',
        'onclick' => '',
    ]) }}>
    @if ($href)
        <a href="{{ $href }}">{{ $label }}</a>
    @else
        {{ $label }}
    @endif
</button>
