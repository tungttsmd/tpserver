<div>
    <div class="flex flex-col gap-4 max-w-[480px]">
        @php
            $list = collect([
                (object) ['id' => 'components', 'name' => 'Bảng linh kiện'],
                (object) ['id' => 'log_components', 'name' => 'Nhật ký linh kiện'],
                (object) ['id' => 'categories', 'name' => 'Danh sách phân loại'],
                (object) ['id' => 'users', 'name' => 'Bảng người dùng'],
                (object) ['id' => 'roles', 'name' => 'Bảng vai trò'],
                (object) ['id' => 'log_user_actions', 'name' => 'Nhật ký hoạt động'],
                (object) ['id' => 'locations', 'name' => 'Bảng vị trí'],
                (object) ['id' => 'customers', 'name' => 'Bảng khách hàng'],
                (object) ['id' => 'vendors', 'name' => 'Bảng đối tác'],
                (object) ['id' => 'statuses', 'name' => 'Bảng trạng thái'],
                (object) ['id' => 'actions', 'name' => 'Bảng hành động'],
            ]);
        @endphp
        {{-- Chọn bảng dữ liệu --}}
        <x-atoms.wrappers.row-flex>
            <x-atoms.form.select livewire-id="fileType" label="Bảng dữ liệu" form-id="fileType" :collection="$list"
                required />
        </x-atoms.wrappers.row-flex>

        <x-atoms.wrappers.row-flex class="justify-between">
            <p>
                Bảng được chọn: <span class="font-medium">{{ $fileType ?: '--' }}</span>
            </p>
        </x-atoms.wrappers.row-flex>

        <x-atoms.wrappers.row-flex class="justify-between">
            <button type="button" wire:click="export" wire:loading.attr="disabled" wire:target="export"
                :disabled="!$fileType" class="disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-file-export mr-2"></i>
                Xuất dữ liệu
            </button>
        </x-atoms.wrappers.row-flex>

        <x-atoms.wrappers.row-flex>
            <span class="text-sm text-gray-600" wire:loading wire:target="export">
                <i class="fas fa-spinner fa-spin mr-2"></i>Đang chuẩn bị dữ liệu, vui lòng chờ...
            </span>
        </x-atoms.wrappers.row-flex>
    </div>
</div>
