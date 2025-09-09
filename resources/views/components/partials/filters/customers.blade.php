<div class="mb-3 flex flex-col md:flex-row md:items-center gap-4 md:gap-6 w-full">

    <!-- Reset + Search -->
    <div>
        <x-atoms.form.button href="{{ route('item.create') }}" type="button" label="Thêm mới" />
        <x-atoms.control.search title="Tìm kiếm" icon="search" placeholder="Name, phone hoặc email..." wire="search" />
        <x-atoms.control.button title="Làm mới" icon="refresh" wire="resetFilters" />
    </div>

    <!-- Dropdowns -->
    <div>
        <x-atoms.control.dropdown wire="perPage" :list="[20 => '20', 50 => '50', 100 => '100', 200 => '200']"
            title="Phân trang" />
    </div>
</div>