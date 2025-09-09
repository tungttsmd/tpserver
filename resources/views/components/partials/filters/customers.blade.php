<div class="mb-3 flex flex-col md:flex-row md:items-center gap-4 md:gap-6 w-full">
    <!-- Reset + Search -->
    <div class="flex flex-col md:flex-row gap-4 flex-grow min-w-0 w-full">
        <x-atoms.form.button href="{{ route('customer.create') }}" type="button" label="Thêm mới" />
        <x-atoms.control.search title="Tìm kiếm" icon="search" placeholder="Name, phone hoặc email..."
            livewireId="search" />
        <x-atoms.control.button title="Làm mới" icon="refresh" livewireId="resetFilters" />
    </div>

    <!-- Dropdowns -->
    <div class="flex flex-col  md:flex-row gap-4 flex-grow min-w-0 whitespace-nowrap">
        <x-atoms.control.dropdown class="w-full" livewireId="perPage" :list="[20 => '20', 50 => '50', 100 => '100', 200 => '200']" title="Phân trang" />
    </div>
</div>
