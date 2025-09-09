@props([
    'name' => '',
    'phone' => '',
    'email' => '',
    'address' => '',
    'note' => '',
])

<div class="livewire-component-container">
    <form wire:submit.prevent="createSubmit" class="max-w-[480px] flex flex-col gap-4 border p-4 rounded-lg">
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded">
                {{ session('success') }}
            </div>
        @elseif (session()->has('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tên nhà cung cấp -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.input livewire-id="name" form-id="name" type="text" label="Tên nhà cung cấp"
                placeholder="Nhập tên nhà cung cấp" required="true" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Điện thoại -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.input livewire-id="phone" form-id="phone" type="tel" label="Điện thoại"
                placeholder="Nhập số điện thoại" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Email -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.input livewire-id="email" form-id="email" type="email" label="Email"
                placeholder="Nhập địa chỉ email" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Địa chỉ -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.input livewire-id="address" form-id="address" type="text" label="Địa chỉ"
                placeholder="Nhập địa chỉ" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Ghi chú -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.textarea livewire-id="note" form-id="note" label="Ghi chú" placeholder="Nhập ghi chú (nếu có)"
                rows="3" />
        </x-atoms.wrappers.row-flex>

        <!-- Nút submit -->
        <x-atoms.wrappers.row-flex class="border justify-between mt-4">
            <x-atoms.form.button type="submit" label="Thêm mới" />
            <x-atoms.form.button wire:click="resetForm" type="button" label="Đặt lại" />
        </x-atoms.wrappers.row-flex>
    </form>
</div>
