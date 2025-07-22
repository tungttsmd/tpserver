<div class="">
    <a href="#" class="btn btn-sm btn-info mb-1" <a href="#"
        onclick="event.preventDefault(); Livewire.emit('modal', 'show','{{ $component->id }}', 'Thông tin chi tiết', 'info','fas fa-eye')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="btn btn-sm btn-warning mb-1" <a href="#"
        onclick="event.preventDefault(); Livewire.emit('modal', 'edit', '{{ $component->id }}', 'Chỉnh sửa thông tin', 'warning','fas fa-edit')">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('components.destroy', $component->id) }}" method="POST" class="d-inline"
        onsubmit="return confirm('Bạn có chắc chắn muốn xoá [{{ $component->serial_number }}]?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger mb-1">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</div>
