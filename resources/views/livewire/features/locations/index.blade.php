        <div class="p-4 w-full">
            {{-- Bộ lọc --}}
            @include('livewire.elements.locations.filter')

            {{-- Thông báo --}}
            @include('livewire.elements.locations.alert')

            {{-- Bảng dữ liệu --}}
            <x-partials.table :list="$data['locations']->toArray()['data']" :columns="$data['columns']" :sort="$sort" :dir="$dir" />

            {{-- Phân trang --}}
            <div class="m-6">
                {{ $data['locations']->links('livewire.elements.components.paginator') }}
            </div>
            {{-- Component style --}}
            <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
        </div>
