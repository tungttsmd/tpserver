<style>
/* CSS tối giản cho components */
.component-form {
    max-width: 800px;
    margin: 0 auto;
    padding: 1.5rem;
}

.form-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
}

.form-card-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-label.required::after {
    content: " *";
    color: #dc2626;
}

.input-group {
    position: relative;
    display: flex;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    overflow: hidden;
    transition: border-color 0.2s ease;
}

.input-group:focus-within {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.input-group-text {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    background: #f9fafb;
    color: #6b7280;
    border: none;
    font-size: 0.875rem;
}

.form-control {
    flex: 1;
    padding: 0.75rem 1rem;
    border: none;
    outline: none;
    font-size: 0.875rem;
    background: #fff;
}

.form-control:focus {
    outline: none;
}

.form-select {
    flex: 1;
    padding: 0.75rem 1rem;
    border: none;
    outline: none;
    font-size: 0.875rem;
    background: #fff;
    cursor: pointer;
}

.form-select:focus {
    outline: none;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.form-check-input {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid #d1d5db;
    border-radius: 4px;
    cursor: pointer;
}

.form-check-input:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

.form-check-label {
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    margin: 0;
}

.warranty-section {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 6px;
    padding: 1.5rem;
    margin: 1.5rem 0;
}

.warranty-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.warranty-fields {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.warranty-field {
    flex: 1;
    min-width: 200px;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-primary {
    background: #3b82f6;
    color: #fff;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-secondary {
    background: #6b7280;
    color: #fff;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1rem;
}

.btn-group {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-group .btn {
    flex: 1;
}

.form-row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.form-row .form-group {
    flex: 1;
    min-width: 200px;
}

/* Responsive */
@media (max-width: 768px) {
    .component-form {
        padding: 1rem;
    }
    
    .form-card-body {
        padding: 1.5rem;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .warranty-fields {
        flex-direction: column;
    }
    
    .warranty-field {
        min-width: auto;
    }
}
</style>

<div class="component-form">
    <div class="form-card">
        <div class="form-card-body">
            <form wire:submit.prevent="update">
                @php
                    $categoryOptions = [];
                    $conditionOptions = [];
                    $manufacturerOptions = [];

                    foreach ($categories as $category) {
                        $categoryOptions[$category->id] = $category->name;
                    }
                    foreach ($conditions as $condition) {
                        $conditionOptions[$condition->id] = $condition->name;
                    }
                    foreach ($manufacturers as $manufacturer) {
                        $manufacturerOptions[$manufacturer->id] = $manufacturer->name;
                    }
                @endphp

                <div class="overflow-y-scroll h-[64vh]">
                    <!-- Serial Number (Readonly) -->
                    <div class="form-group">
                        <label for="serial_number" class="form-label required">Serial number</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-barcode"></i>
                            </span>
                            <div class="form-control" readonly>{{ $component->serial_number }}</div>
                        </div>
                    </div>

                    <!-- Tên linh kiện & ngày nhập kho -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label required">Tên linh kiện</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-tags"></i>
                                </span>
                                <input 
                                    wire:model.defer="name" 
                                    type="text" 
                                    id="name"
                                    class="form-control" 
                                    required 
                                    placeholder="Nhập tên linh kiện"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stockin_at" class="form-label required">Ngày nhập kho</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input 
                                    wire:model.defer="stockin_at" 
                                    type="date" 
                                    id="stockin_at"
                                    class="form-control" 
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Nguồn nhập -->
                    <div class="form-group">
                        <label for="stockin-source" class="form-label">Nguồn nhập</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-barcode"></i>
                            </span>
                            <input 
                                wire:model.defer="stockin_source" 
                                type="text" 
                                id="stockin-source"
                                class="form-control" 
                                placeholder="Nguồn nhập"
                            >
                        </div>
                    </div>

                    <!-- Bảo hành -->
                    <div class="warranty-section">
                        <div class="warranty-header">
                            <input type="checkbox" wire:model="toggleWarranty" class="form-check-input">
                            <i class="fas fa-shield-alt"></i>
                            <span class="form-check-label">Linh kiện có bảo hành</span>
                        </div>
                        
                        @if ($toggleWarranty)
                            <div class="warranty-fields">
                                <div class="warranty-field">
                                    <label for="warranty_start" class="form-label">Ngày bắt đầu bảo hành</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-shield-alt"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="warranty_start" 
                                            type="date" 
                                            id="warranty_start"
                                            class="form-control" 
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="warranty-field">
                                    <label for="warranty_end" class="form-label">Ngày kết thúc bảo hành</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="warranty_end" 
                                            type="date" 
                                            id="warranty_end"
                                            class="form-control" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Phân loại -->
                    <div class="form-group">
                        <label for="category_id" class="form-label">Phân loại</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-cogs"></i>
                            </span>
                            <select 
                                wire:model.defer="category_id" 
                                id="category_id" 
                                class="form-select"
                            >
                                <option value="">-- Chọn phân loại --</option>
                                @foreach ($categoryOptions as $key => $option)
                                    <option value="{{ $key }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Các field chọn còn lại -->
                    @foreach ([
                    [
                        'livewire' => 'condition_id',
                        'label' => 'Tình trạng',
                        'icon' => 'fas fa-microchip',
                        'options' => $conditionOptions,
                    ],
                    ['livewire' => 'manufacturer_id', 'label' => 'Hãng sản xuất', 'icon' => 'fas fa-industry', 'options' => $manufacturerOptions],
                ] as $field)
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



                    <!-- Mô tả -->
                    <div class="mb-3">
                        <label for="note" class="form-label">Mô tả</label>
                        <textarea wire:model.defer="note" id="note" rows="3" class="form-control input-hover"
                            placeholder="Ghi chú về linh kiện"></textarea>
                    </div>

                </div>

                <!-- Nút -->
                <div class="d-flex mt-3 justify-content-between">
                    <button type="submit" class="btn bg-main text-white btn-hover">
                        <i class="fas fa-save me-2"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
