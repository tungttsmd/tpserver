@props([
    'recordId',
    'setIdFunction' => null,
    'action' => null,
    'title' => '',
    'color' => 'primary',
    'icon' => 'fas fa-edit',
    'class' => '',
])
<a href="#"
    class="x-button text-{{ $color }} {{ $class }}"
    onclick="event.preventDefault();
        @if($setIdFunction)
            Livewire.emit('{{ $setIdFunction }}', {{ $recordId }});
        @endif
    @if($action)
        Livewire.emit('modal', '{{ $action }}', '{{ $recordId }}', '{{ $title }}', '{{ $color }}', '{{ $icon }}');
    @endif
  "><i class="{{ $icon }}"></i>
</a>
