@props([
    'type' => 'info',
    'message' => '',
    'errors' => null
])

@if($type === 'error' && $errors && $errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@elseif($type === 'success' && $message)
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i>{{ $message }}
    </div>
@elseif($type === 'info' && $message)
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>{{ $message }}
    </div>
@elseif($type === 'warning' && $message)
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
    </div>
@endif
