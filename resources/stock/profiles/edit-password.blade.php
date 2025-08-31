<div class="p-6 bg-white shadow rounded grow flex flex-column max-w-[480px]">
    <h4 class="h2 font-bold mb-4 ">Đổi mật khẩu</h4>

    @if (session()->has('success'))
        <div class="mb-3 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="updatePassword">
        <div class="mb-4">
            <label for="current_password" class="block font-medium">Mật khẩu hiện tại</label>
            <input type="password" id="current_password" wire:model.defer="current_password"
                class="mt-1 w-full border rounded px-3 py-2 @error('current_password') border-red-500 @enderror"
                required>
            @error('current_password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block font-medium">Mật khẩu mới</label>
            <input type="password" id="password" wire:model.defer="password"
                class="mt-1 w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror" required>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block font-medium">Xác nhận mật khẩu</label>
            <input type="password" id="password_confirmation" wire:model.defer="password_confirmation"
                class="mt-1 w-full border rounded px-3 py-2" required>
        </div>

        <div class="flex justify-end space-x-2">
            <button type="submit" class="bg-main px-4 py-2 rounded hv-opacity">
                Cập nhật
            </button>
            <a onclick="event.preventDefault(); Livewire.emit('viewRender','profiles.index')" href="#"
                class="bg-danger px-4 py-2 rounded hv-opacity" style="z-index: 100">Quay lại</a>
        </div>
    </form>
</div>
