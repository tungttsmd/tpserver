<div>
    {{-- Bộ lọc --}}
    <x-partials.filters.items :categories="$categories" />

    {{-- Bảng dữ liệu --}}
    <x-partials.tables.default actions="components" :filter="$filter" :list="$list->items()" :columns="array_keys($columns)"
        :headers="array_values($columns)" :sort="$sort" :dir="$dir"/>

    {{-- Phân trang --}}
    <div>
        {{ $list->links('components.atoms.table.pagination') }}
    </div>
</div>
