<div>
    {{-- Bộ lọc --}}
    <x-partials.filters.vendors />

    {{-- Bảng dữ liệu --}}
    <x-partials.tables.default actions="vendors" :filter="$filter" :list="$list->items()" :columns="array_keys($columns)" :headers="array_values($columns)"
        :sort="$sort" :dir="$dir" />

    {{-- Phân trang --}}
    <div>
        {{ $list->links('components.atoms.table.pagination') }}
    </div>
</div>
