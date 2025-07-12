<div class="w-full mb-2 p-6 bg-white rounded-lg shadow-md">
    <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6 w-full">

        <!-- Reset + Search -->
        <div class="flex flex-col md:flex-row gap-2 flex-grow min-w-0 w-full">
            <button wire:click="resetFilters" type="button"
                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded flex items-center justify-center gap-2 w-full md:w-auto">
                <i class="fas fa-undo"></i> Reset
            </button>

            <input type="text" wire:model.debounce.500ms="search"
                placeholder="Tìm kiếm Serial hoặc Mô tả..."
                class="w-full flex-grow min-w-0 rounded border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <!-- Dropdowns -->
        <div class="flex flex-col md:flex-row gap-3 md:gap-4 w-full">
            <select wire:model="category"
                class="w-full md:min-w-[150px] form-select rounded border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Tất cả phân loại</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <select wire:model="condition"
                class="w-full md:min-w-[150px] form-select rounded border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Tất cả tình trạng</option>
                @foreach ($conditions as $cond)
                    <option value="{{ $cond->id }}">{{ $cond->name }}</option>
                @endforeach
            </select>

            @if ($table !== 'component-stock' && $table !== 'component-export')
                <select wire:model="status"
                    class="w-full md:min-w-[150px] form-select rounded border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Tất cả trạng thái</option>
                    @foreach ($statuses as $stat)
                        <option value="{{ $stat->id }}">{{ $stat->name }}</option>
                    @endforeach
                </select>
            @endif

            <select wire:model="perPage"
                class="w-full md:w-[100px] form-select rounded border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="80">80</option>
                <option value="100">100</option>
                <option value="200">200</option>
            </select>
        </div>
    </div>
</div>
