<div class="mb-3 flex flex-col md:flex-row md:items-center gap-4 md:gap-6 w-full">
    <!-- Reset + Search -->
    <div class="flex flex-col md:flex-row gap-4 flex-grow min-w-0">
        <x-atoms.form.button href="{{ route('role.create') }}" type="button" label="Tạo vai trò" />
        <x-atoms.control.search title="Tìm kiếm" icon="search" livewire-id="search" />
        <x-atoms.control.button livewire-id="resetFilters" title="Làm mới" />
    </div>

    <!-- Dropdowns -->
    <div class="flex flex-col md:flex-row gap-3 md:gap-4 justify-end whitespace-nowrap">
        <x-atoms.control.dropdown livewire-id="perPage" default="20" :list="[
            20 => '20',
            30 => '30',
            40 => '40',
            50 => '50',
        ]" title="Phân trang" />
    </div>
</div>
