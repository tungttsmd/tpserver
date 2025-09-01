@props([
    'createSuccess' => null,
    'categories' => collect(),
    'conditions' => collect(),
    'manufacturers' => collect(),
    'toggleWarranty' => false,
])

<!-- Debug info -->
@if(app()->environment('local'))
<div style="background: #f0f0f0; padding: 10px; margin: 10px; border: 1px solid #ccc;">
    <strong>Debug Info:</strong><br>
    Categories count: {{ $categories->count() }}<br>
    Toggle Warranty: {{ $toggleWarranty ? 'true' : 'false' }}<br>
    Create Success: {{ $createSuccess ? 'true' : 'false' }}<br>
    Errors: {{ $errors->count() }}
</div>
@endif

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

.warranty-fields {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 6px;
    padding: 1.5rem;
    margin-top: 1rem;
    display: none;
}

.warranty-fields.show {
    display: block;
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

.alert {
    padding: 1rem 1.5rem;
    border-radius: 6px;
    margin-bottom: 1.5rem;
    border: 1px solid;
}

.alert-danger {
    background: #fef2f2;
    border-color: #fecaca;
    color: #dc2626;
}

.alert-success {
    background: #f0fdf4;
    border-color: #bbf7d0;
    color: #16a34a;
}

.alert ul {
    margin: 0;
    padding-left: 1.5rem;
}

.alert li {
    margin-bottom: 0.25rem;
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
}
</style>

<div class="component-form">
    <div class="form-card">
        <div class="form-card-body">
            <!-- Thông báo lỗi -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Thông báo thành công -->
            @if ($createSuccess)
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Thêm mới thành công!
                </div>
            @endif

            <form wire:submit.prevent="createSubmit" class="needs-validation" novalidate>
                <!-- Serial Number -->
                <div class="form-group">
                    <label for="serial_number" class="form-label required">
                        Serial Number
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-barcode"></i>
                        </span>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="serial_number"
                            wire:model.defer="serial_number"
                            placeholder="Nhập serial number"
                            required
                        >
                    </div>
                </div>

                <!-- Tên linh kiện -->
                <div class="form-group">
                    <label for="name" class="form-label required">
                        Tên linh kiện
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-tags"></i>
                        </span>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="name"
                            wire:model.defer="name"
                            placeholder="Nhập tên linh kiện"
                            required
                        >
                    </div>
                </div>

                <!-- Ngày nhập kho -->
                <div class="form-group">
                    <label for="stockin_at" class="form-label required">
                        Ngày nhập kho
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="stockin_at"
                            wire:model.defer="stockin_at"
                            required
                        >
                    </div>
                </div>

                <!-- Phân loại -->
                <div class="form-group">
                    <label for="category_id" class="form-label required">
                        Phân loại
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-cogs"></i>
                        </span>
                        <select 
                            class="form-select" 
                            id="category_id"
                            wire:model.defer="category_id"
                            required
                        >
                            <option value="">-- Chọn phân loại --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Bảo hành -->
                <div class="form-group">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="has_warranty"
                            wire:click="toggleWarranty($event.target.checked)"
                        >
                        <label class="form-check-label" for="has_warranty">
                            Linh kiện có bảo hành
                        </label>
                    </div>
                </div>

                <div id="warranty-fields" class="warranty-fields {{ $toggleWarranty ? 'show' : '' }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="warranty_start" class="form-label">Ngày bắt đầu bảo hành</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-shield-alt"></i>
                                    </span>
                                    <input 
                                        type="date" 
                                        class="form-control" 
                                        id="warranty_start"
                                        wire:model.defer="warranty_start"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="warranty_end" class="form-label">Ngày kết thúc bảo hành</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input 
                                        type="date" 
                                        class="form-control" 
                                        id="warranty_end"
                                        wire:model.defer="warranty_end"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mô tả -->
                <div class="form-group">
                    <label for="note" class="form-label">Ghi chú</label>
                    <textarea 
                        class="form-control" 
                        id="note"
                        wire:model.defer="note"
                        rows="4"
                        placeholder="Ghi chú về linh kiện"
                        style="border: 1px solid #d1d5db; border-radius: 6px; padding: 0.75rem;"
                    ></textarea>
                </div>

                <!-- Nút submit -->
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i>
                        Thêm mới
                    </button>
                    <button type="button" class="btn btn-secondary btn-lg" onclick="resetForm()">
                        <i class="fas fa-times"></i>
                        Hủy bỏ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Component Create loaded');
    
    // Khởi tạo các element
    const stockinAtInput = document.getElementById('stockin_at');
    const warrantyStartInput = document.getElementById('warranty_start');
    const warrantyEndInput = document.getElementById('warranty_end');
    const warrantyCheckbox = document.getElementById('has_warranty');
    const warrantyFields = document.getElementById('warranty-fields');
    
    console.log('Elements found:', {
        stockinAtInput: !!stockinAtInput,
        warrantyStartInput: !!warrantyStartInput,
        warrantyEndInput: !!warrantyEndInput,
        warrantyCheckbox: !!warrantyCheckbox,
        warrantyFields: !!warrantyFields
    });
    
    // Set ngày mặc định cho ngày nhập kho nếu chưa có
    if (stockinAtInput && !stockinAtInput.value) {
        const today = new Date().toISOString().split('T')[0];
        stockinAtInput.value = today;
        console.log('Set default date:', today);
        // Trigger Livewire update
        stockinAtInput.dispatchEvent(new Event('input', { bubbles: true }));
    }
});

// Livewire event listener
document.addEventListener('livewire:load', function() {
    console.log('Livewire loaded');
});

// Function reset form
function resetForm() {
    console.log('Reset form called');
    const form = document.querySelector('form');
    if (form) {
        form.reset();
    }
    
    // Set ngày nhập kho về hôm nay
    const stockinAtInput = document.getElementById('stockin_at');
    if (stockinAtInput) {
        const today = new Date().toISOString().split('T')[0];
        stockinAtInput.value = today;
        stockinAtInput.dispatchEvent(new Event('input', { bubbles: true }));
    }
    
    // Ẩn field bảo hành
    const warrantyFields = document.getElementById('warranty-fields');
    if (warrantyFields) {
        warrantyFields.classList.remove('show');
    }
    
    // Uncheck checkbox bảo hành
    const warrantyCheckbox = document.getElementById('has_warranty');
    if (warrantyCheckbox) {
        warrantyCheckbox.checked = false;
    }
}
</script>
