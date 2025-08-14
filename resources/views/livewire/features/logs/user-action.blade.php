<div class="p-4 w-full">
    {{-- Bộ lọc --}}
    <x-partials.filters.component-logs />

    {{-- Bảng dữ liệu --}}
    <x-partials.tables.default :filter="$filter" :list="$logUserActions->toArray()['data']" :columns="$columns" :sort="$sort"
        :dir="$dir" />
    <!-- Pagination -->
    <div class="mt-4">
        {{ $logUserActions->links('components.atoms.table.pagination') }}
    </div>

    {{-- Component style --}}
    <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
    <span>{{ session('route.controller') }}</span>
    || <span>{{ session('route.action') }}</span>
    || <span>{{ session('route.filter') }}</span>
</div>
