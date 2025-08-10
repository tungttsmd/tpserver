@props([
'recordId' => null,
])

<a href="#" class="x-button text-info"
    onclick="event.preventDefault(); Livewire.emit('record', {{ $recordId }}); Livewire.emit('modal', 'show','{{ $recordId }}', 'Thông tin chi tiết', 'info','fas fa-eye')">
    <i class="fas fa-eye"></i>
</a>
<a href="#" class="x-button text-warning"
    onclick="event.preventDefault();Livewire.emit('record', {{ $recordId }}); Livewire.emit('modal', 'edit', '{{ $recordId }}', 'Chỉnh sửa thông tin', 'warning','fas fa-edit')">
    <i class="fas fa-edit"></i>
</a>
<a href="#" class="x-button text-danger"
    onclick="event.preventDefault();Livewire.emit('record', {{ $recordId }}); Livewire.emit('modal', 'stockreturn', '{{ $recordId }}', 'Lý do thu hồi', 'danger','fas fa-plane-arrival')">
    <i class="fas fa-plane-arrival"></i>
</a>
