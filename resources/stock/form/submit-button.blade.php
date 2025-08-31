@props([
    'text' => 'Gửi',
    'icon' => 'fas fa-paper-plane',
    'type' => 'submit',
    'color' => 'primary',
    'size' => 'md'
])

<div class="d-grid">
    <button 
        type="{{ $type }}" 
        class="btn btn-{{ $color }} btn-{{ $size }}"
    >
        <i class="{{ $icon }} me-2"></i>{{ $text }}
    </button>
</div>
