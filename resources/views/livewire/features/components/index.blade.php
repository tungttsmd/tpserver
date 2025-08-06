        <div class="p-4 w-full">
            {{-- Bộ lọc --}}
            @include('livewire.elements.components.filter')

            {{-- Thông báo --}}
            @include('livewire.elements.components.alert')

            {{-- Bảng dữ liệu --}}
            <x-partials.table actions="components" :list="$data['components']->toArray()['data']" :columns="$data['columns']" :sort="$sort"
                :dir="$dir" />

            {{-- Phân trang --}}
            <div class="m-6">
                {{ $data['components']->links('components.atoms.table.pagination') }}
            </div>
            {{-- Component style --}}
            <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
        </div>
