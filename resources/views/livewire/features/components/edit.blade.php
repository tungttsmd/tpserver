<form wire:submit.prevent="update">
    @php
        $categoryOptions = [];
        $conditionOptions = [];
        $locationOptions = [];
        $vendorOptions = [];
        $manufacturerOptions = [];

        foreach ($categories as $category) {
            $categoryOptions[$category->id] = $category->name;
        }
        foreach ($conditions as $condition) {
            $conditionOptions[$condition->id] = $condition->name;
        }
        foreach ($locations as $location) {
            $locationOptions[$location->id] = $location->name;
        }
        foreach ($vendors as $vendor) {
            $vendorOptions[$vendor->id] = $vendor->name;
        }
        foreach ($manufacturers as $manufacturer) {
            $manufacturerOptions[$manufacturer->id] = $manufacturer->name;
        }
    @endphp

    <div class="mb-3">
        <label for="serial_number" class="form-label">Serial number<span class="text-warning"> *</span></label>
        <div class="input-group border-main">
            <span class="input-group-text border-0"><i class="fas fa-barcode"></i></span>
            {{ dd($componentId) }}
            <div class="form-control input-hover bg-light" readonly>{{ $serial_number }}</div>
        </div>
        <p class="mt-2 fw-bold" id="code-output-serial_number"></p>
    </div>

    {{-- Tên linh kiện & ngày nhập kho --}}
    <div class="d-flex gap-3 flex-wrap">
        <div class="flex-grow-1">
            <label for="name" class="form-label">Tên linh kiện<span class="text-warning"> *</span></label>
            <div class="input-group border-main">
                <span class="input-group-text border-0"><i class="fas fa-tags"></i></span>
                <input wire:model.defer="name" type="text" id="name" class="form-control input-hover border-0"
                    required placeholder="Nhập tên linh kiện">
            </div>
        </div>

        <div class="flex-grow-1" style="min-width: 200px;">
            <label for="stockin_at" class="form-label">Ngày nhập kho<span class="text-warning"> *</span></label>
            <div class="input-group border-main">
                <span class="input-group-text border-0"><i class="fas fa-calendar-alt"></i></span>
                <input wire:model.defer="stockin_at" type="date" id="stockin_at"
                    class="form-control input-hover border-0" required>
            </div>
        </div>
    </div>

    {{-- Bảo hành --}}
    <div class="p-3 mt-3 rounded" style="border: 1px solid #28a745">
        <div class="text-success p-1 flex rounded gap-3 flex-wrap items-center">
            <input type="checkbox"
                onclick="event.preventDefault(); Livewire.emit('toggleWarranty', {{ $toggleWarranty ? 'null' : 'true' }})"
                {{ $warranty_start ? 'checked' : '' }}>
            <i class="fas fa-shield-alt nav-icon"></i>
            <p class="mb-0">Linh kiện có bảo hành</p>
        </div>

        @if ($toggleWarranty)
            <div class="flex gap-3 flex-wrap mt-3">
                <div class="flex-grow-1 min-w-[200px]">
                    <label for="warranty_start" class="form-label">Ngày bắt đầu bảo hành</label>
                    <div class="input-group border rounded">
                        <span class="input-group-text border-0"><i class="fas fa-shield-alt"></i></span>
                        <input wire:model.defer="warranty_start" type="date" id="warranty_start"
                            class="form-control input-hover border-0" required>
                    </div>
                </div>

                <div class="flex-grow-1 min-w-[200px]">
                    <label for="warranty_end" class="form-label">Ngày kết thúc bảo hành</label>
                    <div class="input-group border rounded">
                        <span class="input-group-text border-0"><i class="fas fa-calendar"></i></span>
                        <input wire:model.defer="warranty_end" type="date" id="warranty_end"
                            class="form-control input-hover border-0" required>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Phân loại --}}
    <div class="mb-3 mt-3">
        <label for="category_id" class="form-label">Phân loại</label>
        <div class="input-group border rounded">
            <span class="input-group-text border-0"><i class="fas fa-cogs"></i></span>
            <select wire:model.defer="category_id" id="category_id" class="form-control input-hover border-0" required>
                <option value="">-- Chọn phân loại --</option>
                @foreach ($categoryOptions as $key => $option)
                    <option value="{{ $key }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Các field chọn còn lại --}}
    @foreach ([['livewire' => 'condition_id', 'label' => 'Tình trạng', 'icon' => 'fas fa-microchip', 'options' => $conditionOptions], ['livewire' => 'location_id', 'label' => 'Vị trí', 'icon' => 'fas fa-map-marker-alt', 'options' => $locationOptions], ['livewire' => 'manufacturer_id', 'label' => 'Hãng sản xuất', 'icon' => 'fas fa-industry', 'options' => $manufacturerOptions], ['livewire' => 'vendor_id', 'label' => 'Nhà cung cấp', 'icon' => 'fas fa-store', 'options' => $vendorOptions]] as $field)
        <div class="mb-3">
            <label for="{{ $field['livewire'] }}" class="form-label">{{ $field['label'] }}</label>
            <div class="input-group border rounded">
                <span class="input-group-text border-0"><i class="{{ $field['icon'] }}"></i></span>
                <select wire:model.defer="{{ $field['livewire'] }}" id="{{ $field['livewire'] }}"
                    class="form-control input-hover border-0">
                    <option value="">-- Chọn {{ strtolower($field['label']) }} --</option>
                    @foreach ($field['options'] as $key => $option)
                        <option value="{{ $key }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endforeach

    {{-- Mô tả --}}
    <div class="mb-3">
        <label for="note" class="form-label">Mô tả</label>
        <textarea wire:model.defer="note" id="note" rows="3" class="form-control input-hover"
            placeholder="Ghi chú về linh kiện"></textarea>
    </div>

    {{-- Nút --}}
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn bg-main text-white btn-hover">
            <i class="fas fa-save me-2"></i> Lưu thay đổi
        </button>
        <button type="button" onclick="closePopup()" class="btn btn-secondary">
            <i class="fas fa-times me-1"></i> Đóng
        </button>
    </div>
</form>
