<div class="">
    <a href="#" class="x-button text-danger"
        onclick="event.preventDefault(); Livewire.emit('componentId', {{ $component->id }}); Livewire.emit('modal', 'delete', '{{ $component->id }}', 'Xoá dữ liệu', 'danger','fas fa-trash')">
        <i class="fas fa-trash"></i>
        {{-- Chưa có livewire delete --}}
    </a>
    <a href="#" class="x-button text-warning"
        onclick="event.preventDefault(); Livewire.emit('componentId', {{ $component->id }}); Livewire.emit('modal', 'edit', '{{ $component->id }}', 'Chỉnh sửa thông tin', 'warning','fas fa-edit')">
        <i class="fas fa-edit"></i>
    </a>
    <a href="#" class="x-button text-success"
        onclick="event.preventDefault(); Livewire.emit('componentId', {{ $component->id }}); Livewire.emit('modal', 'stockout','{{ $component->id }}', 'Lý do xuất kho', 'success','fas fa-plane-departure')">
        <i class="fas fa-plane-departure">{{ $component->id }}</i>
    </a>
    <a href="#" class="x-button text-info"
        onclick="event.preventDefault(); Livewire.emit('componentId', {{ $component->id }}); Livewire.emit('modal', 'show','{{ $component->id }}', 'Thông tin chi tiết', 'info','fas fa-eye')">
        <i class="fas fa-eye"></i>
    </a>
</div>
