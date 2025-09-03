@props(['categories' => ''])

<div class="mb-3 flex flex-col md:flex-row md:items-center gap-4 md:gap-6 w-full">
    <!-- Reset + Search -->
    <div>
        <x-atoms.form.button href="{{ route('item.create') }}" type="button" label="Thêm mới" />
        <x-atoms.control.search title="Tìm kiếm" icon="search" livewireId="search" />
        <x-atoms.control.button livewireId="resetFilters" title="Reset" />
    </div>

    <!-- Dropdowns -->
    <div>
        <x-atoms.control.dropdown livewireId="category" :list="$categories" title="Phân loại" item="name" />
        <x-atoms.control.dropdown livewireId="perPage" :list="[20 => '20', 50 => '50', 100 => '100', 200 => '200']"
            title="Phân trang" />
    </div>
</div>