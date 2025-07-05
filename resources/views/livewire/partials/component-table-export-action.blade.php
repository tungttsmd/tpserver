<form action="{{ route('components.recallpost', $component->id) }}" method="POST" class="d-inline"
    onsubmit="return confirm('Bạn có chắc chắn muốn thu hồi {{ $component->category }} [{{ $component->serial_number }}] ?');">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-sm btn-success">
        <i class="far fa-minus-square mr-2"></i>
        <span>Thu hồi</span>
    </button>
</form>
<a href="{{ route('components.show', $component->id) }}" class="btn btn-sm btn-info me-1">
    <i class="fas fa-eye"></i>
</a>
