@props([
    'permissionGroups' => collect(),
])

<div class="livewire-component-container">
    <form wire:submit.prevent="createSubmit" novalidate class="flex flex-col gap-4 max-w-4xl">
        <!-- Tên vai trò -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.input livewire-id="name" form-id="name" type="text" label="Nhập tên vai trò không dấu (Ví dụ: guest)"
                placeholder="Nhập tên vai trò" required="true" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Tên hiển thị -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.input livewire-id="displayName" form-id="display_name" type="text" label="Tên hiển thị của vai trò"
                placeholder="Nhập tên hiển thị" required="true" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Danh sách quyền -->
        <x-atoms.wrappers.row-flex class="flex-col items-start gap-2">
            <label class="block text-sm font-medium text-gray-700">Phân quyền</label>
            <div class="w-full space-y-3">
                @forelse($permissionGroups as $group => $permissions)
                    <div class="border rounded-md overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2 border-b">
                            <h3 class="font-medium text-gray-700">{{ $group }}</h3>
                        </div>
                        <div class="p-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($permissions as $permission)
                                <x-atoms.form.checkbox-multi 
                                    name="selectedPermissions"
                                    :label="$permission['display_name']"
                                    :value="$permission['name']"
                                    wire:model.defer="selectedPermissions"
                                    :checked="in_array($permission['name'], $selectedPermissions ?? [])"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                />
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Không có quyền nào được định nghĩa</p>
                @endforelse
            </div>
            @error('selectedPermissions')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </x-atoms.wrappers.row-flex>

        <!-- Nút submit -->
        <x-atoms.wrappers.row-flex class="border-b justify-between mt-4">
            <x-atoms.form.button type="submit" label="Thêm mới" />
            <x-atoms.form.button wire:click="resetForm" type="button" label="Đặt lại" />
        </x-atoms.wrappers.row-flex>
    </form>
</div>
