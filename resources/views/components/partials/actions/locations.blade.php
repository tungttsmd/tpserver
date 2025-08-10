@props([
    'recordId' => null,
])

<a href="#" class="x-button text-info"
    onclick="event.preventDefault(); Livewire.emit('record', {{ $recordId }}); Livewire.emit('modal', 'show','{{ $recordId }}', 'Thông tin chi tiết', 'info','fas fa-eye')">
    <i class="fas fa-eye"></i>
</a>
