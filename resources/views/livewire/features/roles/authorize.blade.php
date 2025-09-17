<div>
    {{-- Bộ lọc --}}
    <x-partials.filters.roles />

    {{-- Bảng dữ liệu --}}
    <x-partials.tables.index :filter="$filter" :list="$list->items()" :columns="array_keys($columns)"
        :headers="array_values($columns)" :sort="$sort" :dir="$dir" />

    {{-- Phân trang --}}
    <div>
        {{ $list->links('components.atoms.table.pagination') }}
    </div>
    
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            const roleModal = new bootstrap.Modal(document.getElementById('roleModal'));

            Livewire.on('showRoleModal', () => {
                roleModal.show();
            });

            Livewire.on('hideRoleModal', () => {
                roleModal.hide();
            });

            // Close modal when clicking outside
            document.getElementById('roleModal').addEventListener('hidden.bs.modal', function() {
                @this.set('showRoleModal', false);
            });
        });
    </script>
@endpush
</div>
