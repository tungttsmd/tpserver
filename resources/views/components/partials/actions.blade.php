@props([
    'value' => 'x-atoms.table.td :value',
    'class' => '',
    'recordId' => null,
])
<td class="px-4 py-3 text-sm text-gray-900 whitespace-nowrap {{ $class }}" title="{{ $value }}">
    <a href="#" class="x-button text-info"
        onclick="event.preventDefault(); Livewire.emit('record', {{ $recordId }}); Livewire.emit('modal', 'show','{{ $recordId }}', 'Thông tin chi tiết', 'info','fas fa-eye')">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="x-button text-warning"
        onclick="event.preventDefault();Livewire.emit('record', {{ $recordId }}); Livewire.emit('modal', 'edit', '{{ $recordId }}', 'Chỉnh sửa thông tin', 'warning','fas fa-edit')">
        <i class="fas fa-edit"></i>
    </a>
</td>
