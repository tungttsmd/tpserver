<div class="d-flex mb-6 p-6 bg-white rounded-lg shadow-md">
    <div class="mb-4 flex flex-col md:flex-row md:items-end md:gap-6 gap-4">
        <!-- Nút Reset + input tìm kiếm -->
        <div class="flex flex-col md:flex-row md:items-center md:gap-2 flex-grow">
            <button wire:click="resetFilters" type="button"
                class="btn-reset bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded w-full md:w-auto flex items-center justify-center gap-2 mb-2 md:mb-0">
                <i class="fas fa-undo"></i> Reset
            </button>
            <input type="text" wire:model.debounce.500ms="search" placeholder="Tìm kiếm Serial hoặc Mô tả."
                class="flex-grow rounded border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <!-- Các select lọc -->
        <div class="flex flex-wrap md:flex-nowrap gap-3 md:gap-4 flex-grow">
            <select wire:model="category"
                class="form-select rounded border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Tất cả phân loại</option>
                <option value="RAM">RAM</option>
                <option value="Chip">Chip</option>
                <option value="VGA">VGA</option>
                <option value="Main">Main</option>
                <option value="Nguồn">Nguồn</option>
                <option value="Quạt">Quạt</option>
                <option value="Khác">Khác</option>
            </select>

            <select wire:model="condition"
                class="form-select rounded border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Tất cả tình trạng</option>
                <option value="Mới">Mới</option>
                <option value="Cũ">Cũ</option>
                <option value="Hư">Hư</option>
            </select>

            @if ($table !== 'component-stock')
                <select wire:model="status"
                    class="form-select rounded border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Sẵn kho">Sẵn kho</option>
                    <option value="Xuất kho">Xuất kho</option>
                </select>
            @endif

            <select wire:model="perPage"
                class="form-select rounded border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 max-w-[100px]">
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="80">80</option>
                <option value="100">100</option>
                <option value="200">200</option>
            </select>
        </div>
    </div>
</div>
