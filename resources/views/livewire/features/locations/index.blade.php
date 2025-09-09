<div>
    {{-- Bộ lọc --}}
    <x-partials.filters.locations />

    {{-- Bảng dữ liệu --}}
    <x-partials.tables.default actions="locations" :filter="$filter" :list="$list->items()" :columns="array_keys($columns)"
        :headers="array_values($columns)" :sort="$sort" :dir="$dir" />

    {{-- Phân trang --}}
    <div class="m-6">
        {{ $list->links('components.atoms.table.pagination') }}
    </div>
</div>
