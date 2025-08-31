<form wire:submit.prevent="updateAvatar" enctype="multipart/form-data" class="space-y-4">
    @if (session()->has('success'))
        <div class="mb-3 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-2">
        <label class="block font-medium mb-1">Chọn ảnh mới</label>
        <input type="file" wire:model="avatar"
            class="w-full border rounded px-3 py-2 @error('avatar') border-red-500 @enderror" accept="image/*">
        @error('avatar')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    @if ($avatar)
        <div class="mt-2">
            <p class="text-sm text-gray-600">Xem trước ảnh:</p>
            <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="h-32 mt-2 rounded shadow">
        </div>
    @endif

    <div class="flex justify-end space-x-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
            wire:loading.attr="disabled">
            Lưu ảnh
        </button>
        <a href="#" onclick="Livewire.emit('viewRender','profiles.index')"
            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Quay lại</a>
    </div>
</form>
