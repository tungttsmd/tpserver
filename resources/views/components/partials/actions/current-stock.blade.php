@props([
'recordId' => null,
])
<div>   
    <a href="#" class="x-button text-info"
        onclick="event.preventDefault(); Livewire.emit('record', '{{ $recordId }}'); Livewire.emit('modal', 'show','{{ $recordId }}', 'Thông tin chi tiết', 'info','fas fa-eye')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="x-button text-warning"
        onclick="event.preventDefault();Livewire.emit('record', '{{ $recordId }}'); Livewire.emit('modal', 'edit', '{{ $recordId }}', 'Chỉnh sửa thông tin', 'warning','fas fa-edit')">
        <i class="fas fa-edit"></i>
    </a>
    <a href="#" class="x-button text-success"
        onclick="event.preventDefault();Livewire.emit('record', '{{ $recordId }}'); Livewire.emit('modal', 'stockout', '{{ $recordId }}', 'Lý do xuất kho', 'success','fas fa-plane-departure')">
        <i class="fas fa-plane-departure"></i>
    </a>
</div>  