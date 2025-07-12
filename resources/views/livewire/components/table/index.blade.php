<div class="tpserver components table container max-w-full ">
    {{-- Bộ lọc --}}
    @include('livewire.components.elements.table-filter')

    {{-- Thông báo --}}
    @include('livewire.components.elements.table-alert')

    {{-- Bảng dữ liệu --}}
    <div class="table-responsive shadow-sm rounded p-0">
        @include('livewire.components.elements.table', ['data' => $data])

    </div>
    {{-- Phân trang --}}
    <div class="m-6">
        {{ $data['components']->links('livewire.components.elements.table-paginator') }}
    </div>
    {{-- Component style --}}
    <link rel="stylesheet" href="{{ asset('css/components/table/index.css') }}">
</div>
