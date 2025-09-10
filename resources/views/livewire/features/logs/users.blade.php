<div class="p-4 w-full">
    {{-- Bộ lọc --}}
    <x-partials.filters.log-users />

    {{-- Bảng dữ liệu --}}
    <x-partials.tables.default actions="log-users" :filter="$filter" :list="$list->items()" :columns="array_keys($columns)"
        :headers="array_values($columns)" :sort="$sort" :dir="$dir" />

    <!-- Pagination -->
    <div class="mt-4">
        {{ $list->links('components.atoms.table.pagination') }}
    </div>
</div>
