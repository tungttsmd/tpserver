        <div class="p-4 w-full">
            {{-- Bộ lọc --}}
            <x-partials.filters.components :categories="$categories" :conditions="$conditions" />

            {{-- Bảng dữ liệu --}}
            <x-partials.tables.default actions="components" :filter="$filter" :list="$data['components']->toArray()['data']" :columns="$data['columns']"
                :sort="$sort" :dir="$dir" />

            {{-- Phân trang --}}
            <div class="m-6">
                {{ $data['components']->links('components.atoms.table.pagination') }}
            </div>
            {{-- Component style --}}
            <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
        </div>
