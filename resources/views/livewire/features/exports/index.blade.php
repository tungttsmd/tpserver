<div class="p-6 w-full mx-auto">
    <h2 class="text-lg font-semibold mb-4">Export dữ liệu</h2>

    {{-- Chọn bảng dữ liệu --}}
    <div class="mb-4">
        <label for="fileType" class="block text-sm font-medium text-gray-700 mb-1">Chọn bảng dữ liệu</label>
        <select id="fileType" wire:model="fileType"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
            <option value="">-- Lựa chọn --</option>
            <option value="components">Bảng linh kiện</option>
            <option value="log_components">Nhật ký linh kiện</option>
            <option value="categories">Danh sách phân loại</option>
            <option value="conditions">Danh sách tình trạng</option>
            <option value="manufacturers">Danh sách hãng sản xuất</option>
            <option value="users">Bảng người dùng</option>
            <option value="roles">Bảng vai trò</option>
            <option value="log_user_actions">Nhật ký hoạt động</option>
            <option value="locations">Bảng vị trí</option>
            <option value="customers">Bảng khách hàng</option>
            <option value="vendors">Bảng đối tác</option>
            <option value="statuses">Bảng trạng thái</option>
            <option value="actions">Bảng hành động</option>
        </select>
    </div>

    {{-- Nút export + loading --}}
    <div class="flex items-center space-x-3">
        <button wire:click="export" wire:loading.attr="disabled" wire:target="export"
            @if (!$fileType) disabled @endif
            class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-10 disabled:cursor-not-allowed transition">
            Export Excel
        </button>

        <span wire:loading wire:target="export" class="text-gray-500 text-sm">
            Đang xuất file...
        </span>
    </div>

    {{-- Hiển thị lựa chọn hiện tại --}}
    <p class="mt-3 text-sm text-gray-600">
        Bảng được chọn: <span class="font-medium">{{ $fileType ?: '--' }}</span>
    </p>
</div>
