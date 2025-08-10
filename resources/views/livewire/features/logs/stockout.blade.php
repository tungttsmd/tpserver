<div class="p-4 w-full">
    {{-- Bộ lọc --}}
    <x-partials.filters.component-logs />

    {{-- Bảng dữ liệu --}}
    <x-partials.tables.component-logs :list="$componentLogs" />

    <!-- Pagination -->
    <div class="mt-4">
        {{ $componentLogs->links('components.atoms.table.pagination') }}
    </div>

    {{-- Component style --}}
    <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">

</div>
