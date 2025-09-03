<form wire:submit.prevent="update">
    @php
        $categoryOptions = [];

        foreach ($categories as $category) {
            $categoryOptions[$category->id] = $category->name;
        }
    @endphp

    <div class="flex flex-col gap-3 overflow-y-auto">
        <span class="flex flex-row justify-between truncate">
            MÃ SẢN PHẨM: <span class="truncate"><strong>{{ $component->serial_number }}</strong></span>
        </span>
        <span>
            <x-atoms.form.input class-input="border rounded text-[#4b6cb7] font-bold"
                class-label="text-[#4b6cb7] font-bold" livewire-id="name" form-id="name" label="Tên linh kiện" type="text"
                required />
        </span>
        <x-atoms.form.select livewire-id="category_id" form-id="category_id" label="Phân loại" :collection="$categories"
            class-input="border rounded" />
        <hr />
        <span>
            <x-atoms.form.input class-input="border rounded " livewire-id="stockin_at" form-id="stockin_at"
                label="Ngày nhập kho" type="date" required />
        </span>
        <span>
            <x-atoms.form.input class-input="border rounded" livewire-id="stockin_source" form-id="stockin_source"
                label="Nguồn nhập" type="text" />
        </span>
        <hr />
        <x-atoms.form.checkbox livewire-id="toggleWarranty" form-id="toggleWarranty" name="toggleWarranty"
            label="Linh kiện có bảo hành" :defer="false" />
        @if ($toggleWarranty)
            <x-atoms.form.input class-input="border rounded" livewire-id="warranty_start" form-id="warranty_start"
                label="Ngày bắt đầu bảo hành" type="date" />
            <x-atoms.form.input class-input="border rounded" livewire-id="warranty_end" form-id="warranty_end"
                label="Ngày kết thúc bảo hành" type="date" />
        @endif
        <hr />
        <x-atoms.form.textarea livewire-id="note" form-id="note" label="Ghi chú" border="true" />
    </div>

    <hr class="my-4" />
    <div class="flex justify-between gap-3">
        <x-atoms.form.button type="submit" label="Lưu thay đổi" color="primary" 
            class="flex-1 py-2 text-sm font-medium" />
        <x-atoms.form.button type="button" label="Đặt lại" color="secondary" 
            wire:click="formRebinding" class="flex-1 py-2 text-sm font-medium" />
    </div>
</form>
