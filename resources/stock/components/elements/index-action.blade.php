     <a href="#" onclick="event.preventDefault(); Livewire.emit('route', 'components', null ,'currentStock')"
         class="btn btn-sm btn-info mb-1">
         <i class="fas fa-eye"></i>
     </a>
     <a href="{{ route('components.edit', $component->id) }}" class="btn btn-sm btn-warning mb-1">
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
