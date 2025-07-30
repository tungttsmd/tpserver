<div class="">
    <a href="#" class="x-button text-danger"
        onclick="event.preventDefault();Livewire.emit('componentId', {{ $componentId }}); Livewire.emit('modal', 'delete', '{{ $componentId }}', 'Xoá dữ liệu', 'danger','fas fa-trash')">
        <i class="fas fa-trash"></i>
        {{-- Chưa có livewire delete --}}
    </a>

    <a href="#" class="x-button text-warning"
        onclick="event.preventDefault();Livewire.emit('componentId', {{ $componentId }}); Livewire.emit('modal', 'edit', '{{ $componentId }}', 'Chỉnh sửa thông tin', 'warning','fas fa-edit')">
        <i class="fas fa-edit"></i>
    </a>

    <a href="#" class="x-button text-danger"
        onclick="event.preventDefault();Livewire.emit('componentId', {{ $componentId }}); Livewire.emit('modal', 'stockreturn','{{ $componentId }}', 'Lý do thu hồi', 'danger','fas fa-plane-arrival')">
        <i class="fas fa-plane-arrival"></i>
    </a>
    <a href="#" class="x-button text-info"
        onclick="event.preventDefault(); Livewire.emit('componentId', {{ $componentId }});Livewire.emit('modal', 'show','{{ $componentId }}', 'Thông tin chi tiết', 'info','fas fa-eye')">
        <i class="fas fa-eye"></i>
    </a>

</div>
