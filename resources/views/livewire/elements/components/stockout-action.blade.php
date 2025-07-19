<div class="">
    <a href="#" class="btn btn-sm btn-info mb-1"
        onclick="event.preventDefault(); Livewire.emit('modal', 'show','{{ $component->id }}', 'Thông tin chi tiết', 'info','fas fa-eye')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="btn btn-sm btn-warning mb-1"
        onclick="event.preventDefault(); Livewire.emit('modal', 'edit', '{{ $component->id }}', 'Chỉnh sửa thông tin', 'warning','fas fa-edit')">
        <i class="fas fa-edit"></i>
    </a>
    <a href="#" class="btn btn-sm btn-success mb-1 pr-3"
        onclick="event.preventDefault(); Livewire.emit('modal', 'stockout','{{ $component->id }}', 'Lý do xuất kho', 'success','fas fa-minus-square')">
        <i class="fas fa-minus-square"></i>
        <span>Xuất</span>
    </a>
</div>
