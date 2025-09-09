@props([
    'name' => '',
    'note' => '',
])

<div class="livewire-component-container">
    <form wire:submit.prevent="createSubmit" novalidate class="max-w-[480px] flex flex-col gap-4 border p-4 rounded-lg">
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded">
                {{ session('success') }}
            </div>
        @elseif (session()->has('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tên vị trí -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.input
                livewire-id="name"
                form-id="name"
                type="text"
                label="Tên vị trí"
                placeholder="Nhập tên vị trí"
                required="true"
                class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Ghi chú -->
        <x-atoms.wrappers.row-flex class="border justify-between">
            <x-atoms.form.textarea
                livewire-id="note"
                form-id="note"
                label="Ghi chú"
                placeholder="Nhập ghi chú (nếu có)"
                rows="3" />
        </x-atoms.wrappers.row-flex>

        <!-- Nút submit -->
        <x-atoms.wrappers.row-flex class="border justify-between mt-4">
            <x-atoms.form.button type="submit" label="Thêm mới" />
            <x-atoms.form.button wire:click="resetForm" type="button" label="Đặt lại" />
        </x-atoms.wrappers.row-flex>
    </form>
</div>
