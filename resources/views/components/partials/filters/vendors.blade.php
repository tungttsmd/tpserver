<div class="mb-3 flex flex-col md:flex-row md:items-center gap-4 md:gap-6 w-full">
    <!-- Reset + Search -->
    <div class="flex flex-col md:flex-row gap-4 flex-grow min-w-0 w-full">
        <x-atoms.form.button href="{{ route('vendor.create') }}" type="button" label="Thêm mới" />
        <x-atoms.control.search title="Tìm kiếm" icon="search" placeholder="Name, phone hoặc email..." livewire-id="search" />
        <x-atoms.control.button title="Làm mới" icon="refresh" livewire-id="resetFilters" />

    </div>

    <!-- Dropdowns -->
    <div class="flex flex-col md:flex-row gap-3 md:gap-4 w-full justify-end">
        {{-- <x-atoms.control.dropdown livewire-id="category" :list="$categories" title="Phân loại" item="name" /> --}}
        {{-- <x-atoms.control.dropdown livewire-id="condition" :list="$conditions" title="Tình trạng" item="name" y/> --}}
        <x-atoms.control.dropdown livewire-id="perPage" :list="[20 => '20', 50 => '50', 100 => '100', 200 => '200']" title="Phân trang" />
    </div>
</div>
