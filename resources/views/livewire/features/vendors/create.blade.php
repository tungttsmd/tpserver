@props([
    'name' => '',
    'phone' => '',
    'email' => '',
    'address' => '',
    'logo_url' => '',
    'note' => '',
])

<div class="flex flex-col md:flex-row gap-8 p-4 w-full">
    {{-- Cột phải: Logo + Thông tin --}}
    <div class="md:w-1/2 flex flex-col gap-12 p-4 border rounded-lg shadow-sm">
        {{-- Logo --}}
        <div class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-2xl p-4 min-h-[150px] transition-opacity duration-300"
            @class(['opacity-60' => !$logo_url])>
            <img src="{{ $logo_url ?: 'https://via.placeholder.com/150' }}" alt="Logo"
                class="max-w-[70%] max-h-[70%] object-contain mr-12">
            @if (!$logo_url)
                <p class="text-sm text-gray-500 mr-16">Logo sẽ hiển thị tại đây</p>
            @endif
        </div>

        {{-- Thông tin --}}
        <div class="flex-1 overflow-y-auto bg-white border rounded-xl p-4 max-h-[300px]">
            <h5 class="text-green-600 font-semibold mb-3 flex items-center">
                <i class="fas fa-store mr-2"></i>Thông tin nhà cung cấp
            </h5>
            <ul class="text-sm divide-y divide-gray-200">
                <li class="py-2"><strong>Tên:</strong> <span>{{ $name ?: '-' }}</span></li>
                <li class="py-2"><strong>Điện thoại:</strong> <span>{{ $phone ?: '-' }}</span></li>
                <li class="py-2"><strong>Email:</strong> <span>{{ $email ?: '-' }}</span></li>
                <li class="py-2"><strong>Địa chỉ:</strong> <span>{{ $address ?: '-' }}</span></li>
                <li class="py-2"><strong>Ghi chú:</strong> <span>{{ $note ?: '-' }}</span></li>
            </ul>
        </div>
    </div>

    {{-- Cột trái: Form nhập --}}
    <div class="md:w-1/2 p-4 border rounded-lg shadow-sm">
        <form wire:submit.prevent="createVendor" class="space-y-6">
            @if (session()->has('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded">
                    {{ session('success') }}
                </div>
            @else
                <div class="bg-green-100 text-green-800 p-4 rounded">
                    {{ session('error') }}
                </div>
            @endif
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tên nhà cung cấp <span
                        class="text-red-500">*</span></label>
                <input wire:model.defer="name" type="text" id="name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    required>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Điện thoại</label>
                <input wire:model.defer="phone" type="tel" id="phone"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('phone')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input wire:model.defer="email" type="email" id="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                <input wire:model.defer="address" type="text" id="address"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('address')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="logo_url" class="block text-sm font-medium text-gray-700">Logo (URL)</label>
                <input wire:model.defer="logo_url" type="text" id="logo_url"
                    placeholder="Dán link logo để xem trước"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('logo_url')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="note" class="block text-sm font-medium text-gray-700">Ghi chú</label>
                <textarea wire:model.defer="note" id="note" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    placeholder="Ghi chú về nhà cung cấp"></textarea>
                @error('note')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-white text-sm font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <i class="fas fa-save mr-2"></i> Lưu nhà cung cấp
            </button>
        </form>
    </div>
</div>
