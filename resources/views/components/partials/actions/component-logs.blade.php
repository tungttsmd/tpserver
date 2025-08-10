@props(['class' => '', 'value' => ''])

<td class="text-center">
    <a href="#" class="x-button {{ $class }}"
        onclick="event.preventDefault(); Livewire.emit('record', {{ $value }}); Livewire.emit('modal', 'show','{{ $value }}', 'Thông tin chi tiết', 'info','fas fa-eye')">
        <i class="fas fa-eye"></i>
    </a>
</td>
