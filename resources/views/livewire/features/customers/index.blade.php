        <div class="p-4 w-full">
            {{-- Bộ lọc --}}
            @include('livewire.elements.customers.filter')

            {{-- Thông báo --}}
            @include('livewire.elements.customers.alert')

            {{-- Bảng dữ liệu --}}
            <x-partials.table :list="$data['customers']->toArray()['data']" :columns="$data['columns']" :sort="$sort" :dir="$dir" />

            {{-- Phân trang --}}
            <div class="m-6">
                {{ $data['customers']->links('livewire.elements.components.paginator') }}
            </div>
            {{-- Component style --}}
            <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
        </div>
