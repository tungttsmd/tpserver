@props([
    'recordId' => '-1',
])
<div>
    <a href="#" class="x-button text-info"
        onclick="event.preventDefault(); 
        Livewire.emit('record', '{{ $recordId }}'); 
        Livewire.emit('modal', 'show','{{ $recordId }}', 'Thông tin chi tiết', 'info','fas fa-eye')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="x-button text-info"
        onclick="event.preventDefault(); 
        Livewire.emit('record', '{{ $recordId }}'); 
        Livewire.emit('modal', 'edit','{{ $recordId }}', 'Chỉnh sửa vai trò', 'warning','fas fa-edit')">
        <i class="fas fa-edit"></i>
    </a>
</div>
