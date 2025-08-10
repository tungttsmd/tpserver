        <div class="p-4 w-full">
            {{-- Bộ lọc --}}
            <x-partials.filters.vendors />

            {{-- Bảng dữ liệu --}}
            <x-partials.tables.default :filter="$filter" :list="$data['vendors']->toArray()['data']" :columns="$data['columns']" :sort="$sort" :dir="$dir" />

            {{-- Phân trang --}}
            <div class="m-6">
                {{ $data['vendors']->links('components.atoms.table.pagination') }}
            </div>
            {{-- Component style --}}
            <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
        </div>
