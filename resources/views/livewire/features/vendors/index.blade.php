        <div class="p-4 w-full">
            {{-- Bộ lọc --}}
            @include('livewire.elements.vendors.filter')

            {{-- Thông báo --}}
            @include('livewire.elements.vendors.alert')

            {{-- Bảng dữ liệu --}}
            <x-partials.table :list="$data['vendors']->toArray()['data']" :columns="$data['columns']" :sort="$sort" :dir="$dir" />

            {{-- Phân trang --}}
            <div class="m-6">
                {{ $data['vendors']->links('livewire.elements.components.paginator') }}
            </div>
            {{-- Component style --}}
            <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
        </div>
