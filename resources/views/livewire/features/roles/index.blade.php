<div>
    {{-- Bộ lọc --}}
    <x-partials.filters.roles />

    {{-- Bảng dữ liệu --}}
    <x-partials.tables.default :filter="$filter" :list="$list->items()" :columns="array_keys($columns)"
        :headers="array_values($columns)" :sort="$sort" :dir="$dir" />
    
    {{-- Phân trang --}}
    <div class="mt-4">
        {{ $list->links('components.atoms.table.pagination') }}
    </div>
</div>
