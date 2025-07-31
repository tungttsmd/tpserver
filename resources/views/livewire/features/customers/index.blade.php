        <div class="p-4 w-full">
            {{-- Bộ lọc --}}
            {{-- @include('livewire.elements.components.filter') --}}

            {{-- Thông báo --}}
            {{-- @include('livewire.elements.components.alert') --}}

            {{-- Bảng dữ liệu --}}
            <x-table.table
                :controller="session('route')['controller']"
                :action="session('route')['action']"
                :data="$data['customers']"
                :columns="$data['columns']"
                :relationships="[]"
                :sort="$sort"
                :dir="$dir"/>

            {{-- Phân trang --}}
            <div class="m-6">
                {{ $data['customers']->links('livewire.elements.components.paginator') }}
            </div>
            {{-- Component style --}}
            <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
        </div>
