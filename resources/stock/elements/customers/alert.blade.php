    @foreach (['success' => 'danger', 'error' => 'warning'] as $type => $alert)
        @if (session($type))
            <div class="alert alert-{{ $alert }} alert-dismissible fade show mt-3" role="alert">
                <i class="fas {{ $type === 'success' ? 'fa-trash-alt' : 'fa-minus-circle' }} me-2"></i>
                {{ session($type) }}
            </div>
        @endif
    @endforeach
