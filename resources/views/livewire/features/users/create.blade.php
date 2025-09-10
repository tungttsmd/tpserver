@props([
    'avatar_url' => '',
])

<div class="livewire-component-container">
    <form wire:submit.prevent="createSubmit" novalidate class="max-w-[480px] flex flex-col gap-4">
        <!-- Username -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.input livewire-id="username" form-id="username" type="text" label="Tên đăng nhập"
                placeholder="Nhập tên đăng nhập" required="true" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Password -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.input livewire-id="password" form-id="password" type="password" label="Mật khẩu"
                placeholder="Nhập mật khẩu" required="true" class="flex w-full justify-between" />
                </x-atoms.wrappers.row-flex>

        <!-- Confirm Password -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.input livewire-id="password_confirmation" form-id="password_confirmation" type="password" 
                label="Xác nhận mật khẩu" placeholder="Nhập lại mật khẩu" required="true" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Display Name -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.input livewire-id="alias" form-id="alias" type="text" label="Tên hiển thị"
                 placeholder="Nhập tên hiển thị" required="true" class="flex w-full justify-between" />
         </x-atoms.wrappers.row-flex>
   
            <!-- Nút submit -->
           <x-atoms.wrappers.row-flex class="border-b justify-between">
        <x-atoms.form.button type="submit" label="Thêm mới" />
        <x-atoms.form.button wire:click="resetForm" type="button" label="Đặt lại" />
    </x-atoms.wrappers.row-flex>
    </form>
</div>