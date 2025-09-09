@props([
    'name' => '',
    'phone' => '',
    'email' => '',
    'address' => '',
    'note' => '',
])

<div class="livewire-component-container">
    <form wire:submit.prevent="createSubmit" novalidate class="max-w-[480px] flex flex-col gap-4 border p-4 rounded-lg">
        <!-- Tên khách hàng -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.input livewire-id="name" form-id="name" type="text" label="Tên khách hàng"
                placeholder="Nhập tên khách hàng" required="true" class="flex w-full justify-between"
                value="{{ $name }}" />
        </x-atoms.wrappers.row-flex>

        <!-- Số điện thoại -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.input livewire-id="phone" form-id="phone" type="tel" label="Số điện thoại"
                placeholder="Nhập số điện thoại" class="flex w-full justify-between" value="{{ $phone }}" />
        </x-atoms.wrappers.row-flex>

        <!-- Email -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.input livewire-id="email" form-id="email" type="email" label="Email"
                placeholder="Nhập địa chỉ email" class="flex w-full justify-between" value="{{ $email }}" />
        </x-atoms.wrappers.row-flex>

        <!-- Địa chỉ -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.input livewire-id="address" form-id="address" type="text" label="Địa chỉ"
                placeholder="Nhập địa chỉ" class="flex w-full justify-between" value="{{ $address }}" />
        </x-atoms.wrappers.row-flex>

        <!-- Ghi chú -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.textarea livewire-id="note" form-id="note" rows="4"
                placeholder="Ghi chú về khách hàng">{{ $note }}</x-atoms.form.textarea>
        </x-atoms.wrappers.row-flex>

        <!-- Nút submit -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.button type="submit" label="Thêm mới" />
            <x-atoms.form.button wire:click="resetForm" type="button" label="Đặt lại" />
        </x-atoms.wrappers.row-flex>
    </form>
</div>
