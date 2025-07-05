     @if ($component->status === 'Sẵn kho')
         <a href="{{ route('components.exportConfirm', $component->id) }}" <a type="submit"
             class="btn btn-sm btn-success">
             <i class="far fa-minus-square mr-2"></i>
             <span>Xuất kho</span>
         </a>
     @else
         <button type="submit" class="btn btn-sm btn-danger">
             <i class="fas fa-minus-circle mr-2"></i>
             <span>Đã xuất</span>
         </button>
     @endif
     <a href="{{ route('components.show', $component->id) }}" class="btn btn-sm btn-info me-1">
         <i class="fas fa-eye"></i>
     </a>
