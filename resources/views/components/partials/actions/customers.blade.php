@props([
    'recordId' => null,
])

<div class="flex space-x-2">
    @can('customer.show')
    <a href="{{ route('customer.show', $recordId) }}" 
       class="text-blue-600 hover:text-blue-800"
       title="Xem chi tiết">
        <i class="fas fa-eye"></i>
    </a>
    @endcan

    @can('customer.edit')
    <a href="{{ route('customer.edit', $recordId) }}" 
       class="text-yellow-600 hover:text-yellow-800 ml-2"
       title="Chỉnh sửa">
        <i class="fas fa-pencil-alt"></i>
    </a>
    @endcan
</div>
