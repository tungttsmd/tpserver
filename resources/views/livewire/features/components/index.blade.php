<style>
/* CSS tối giản chung cho components */
.components-container {
    padding: 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.components-header {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.components-title {
    background: #f8fafc;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e5e7eb;
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.components-body {
    padding: 2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .components-container {
        padding: 1rem;
    }
    
    .components-body {
        padding: 1.5rem;
    }
}
</style>

<div class="components-container">
    <div class="components-header">
        <h1 class="components-title">
            <i class="fas fa-cubes"></i>
            Quản lý linh kiện
        </h1>
        
        <div class="components-body">
            {{-- Bộ lọc --}}
            <x-partials.filters.components :categories="$categories" :conditions="$conditions" />

            {{-- Bảng dữ liệu --}}
            <x-partials.tables.default actions="components" :filter="$filter" :list="$data['components']->toArray()['data']" :columns="$data['columns']"
                :sort="$sort" :dir="$dir" />

            {{-- Phân trang --}}
            <div class="m-6">
                {{ $data['components']->links('components.atoms.table.pagination') }}
            </div>
        </div>
    </div>
</div>
