@props([
    'categories' => collect(),
    'toggleWarranty' => false,
])
<div class="livewire-component-container">
    <form wire:submit.prevent="createSubmit" novalidate class="max-w-[480px] flex flex-col gap-4">
        <!-- Serial Number -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.input livewire-id="serial_number" form-id="serial_number" type="text" label="Serial number"
                placeholder="Nhập serial number" required="true" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Tên linh kiện -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.input livewire-id="name" form-id="name" type="text" label="Tên linh kiện"
                placeholder="Nhập tên linh kiện" required="true" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Ngày nhập kho -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.input livewire-id="stockin_at" form-id="stockin_at" type="date" label="Ngày nhập kho"
                required="true" class="flex w-full justify-between" />
        </x-atoms.wrappers.row-flex>

        <!-- Phân loại -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.select livewire-id="category_id" :collection="$categories" item-id="id" item-name="name"
                label="Phân loại" defer="true" />
        </x-atoms.wrappers.row-flex>

        <!-- Bảo hành -->
        <x-atoms.wrappers.row-flex class="border-b gap-x-0">
            <x-atoms.form.checkbox livewire-id="toggleWarranty" form-id="has_warranty" label="Linh kiện có bảo hành"
                defer="false" />
        </x-atoms.wrappers.row-flex>

        <x-atoms.wrappers.row-flex class="justify-between">
            <div id="warranty-fields"
                class="flex flex-col w-full gap-2 @php if(!$toggleWarranty) echo 'hidden'; @endphp">
                <x-atoms.form.input livewire-id="warranty_start" form-id="warranty_start" type="date"
                    label="Ngày bắt đầu bảo hành" class="border-b flex w-full justify-between" />
                <x-atoms.form.input livewire-id="warranty_end" form-id="warranty_end" type="date"
                    label="Ngày kết thúc bảo hành" class="border-b flex w-full justify-between" />
            </div>
        </x-atoms.wrappers.row-flex>

        <!-- Mô tả -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.textarea livewire-id="note" form-id="note" rows="4" placeholder="Ghi chú linh kiện" />
        </x-atoms.wrappers.row-flex>

        <!-- Nút submit -->
        <x-atoms.wrappers.row-flex class="border-b justify-between">
            <x-atoms.form.button type="submit" label="Thêm mới" />
            <x-atoms.form.button wire:click="resetForm" type="button" label="Đặt lại" />
        </x-atoms.wrappers.row-flex>
    </form>

    <script src="{{ asset('js/views/items.create.js') }}"></script>
    <script>
        const itemCreateView = new ItemCreateView({
            formSelector: 'form',
            stockinAtId: 'stockin_at',
            warrantyStartId: 'warranty_start',
            warrantyEndId: 'warranty_end',
            hasWarrantyId: 'has_warranty'
        });
    </script>
</div>
