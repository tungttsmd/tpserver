<div class="tpserver components table w-full">
    {{-- {{ dd(get_defined_vars()) }} // Debug LayoutController --}}

    {{-- Header --}}
    <header class="sticky top-0 z-50 w-full bg-main text-white shadow-md flex items-center justify-between px-4 py-2 z-50">
        {{-- Trái: menu + tiêu đề --}}
        <div class="flex items-center gap-4">
            {{-- Nút mở sidebar --}}
            @include('layouts.elements.headernav-push-menu')

            {{-- Tiêu đề --}}
            <h1 class="text-lg font-semibold whitespace-nowrap">
                <i class="fas fa-boxes mr-2"></i> Danh sách linh kiện
            </h1>
        </div>

        {{-- Phải: nút scan + logout --}}
        <div class="flex items-center gap-3">
            @include('layouts.elements.headernav-scan')
            <livewire:component-controller component="button-logout" />
        </div>
    </header>


    <div class="py-4 w-full">
        {{-- Bộ lọc --}}
        @include('livewire.elements.components.filter')

        {{-- Thông báo --}}
        @include('livewire.elements.components.alert')

        {{-- Bảng dữ liệu --}}
        @include('livewire.elements.components.table')

        {{-- Phân trang --}}
        <div class="m-6">
            {{ $data['components']->links('livewire.elements.components.paginator') }}
        </div>
    </div>

    {{-- Component style --}}
    <link rel="stylesheet" href="{{ asset('css/components/table/index.css') }}">
</div>
