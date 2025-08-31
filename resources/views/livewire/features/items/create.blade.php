@props([
    'createSuccess' => null,
    'categories' => collect(),
    'conditions' => collect(),
    'manufacturers' => collect(),
    'toggleWarranty' => false,
])

<div class="container-fluid p-3 p-md-4">
    <div class="row justify-content-center">
        <!-- Form chính -->
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card shadow-sm">
                <div class="card-body p-3 p-md-4">
                    <!-- Thông báo lỗi -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Thông báo thành công -->
                    @if ($createSuccess)
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>Thêm mới thành công!
                        </div>
                    @endif

                    <form wire:submit.prevent="createSubmit" class="needs-validation" novalidate>
                        <!-- Serial Number -->
                        <div class="mb-3">
                            <label for="serial_number" class="form-label fw-semibold">
                                Serial Number <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light">
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
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Tên linh kiện <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light">
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
                        <div class="mb-3">
                            <label for="stockin_at" class="form-label fw-semibold">
                                Ngày nhập kho <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light">
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
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-semibold">
                                Phân loại <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light">
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
                        <div class="mb-3">
                            <div class="form-check form-check-lg">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    id="has_warranty"
                                >
                                <label class="form-check-label fw-semibold" for="has_warranty">
                                    Linh kiện có bảo hành
                                </label>
                            </div>
                        </div>

                        <div id="warranty-fields" class="row gap-3" style="display: none;">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="warranty_start" class="form-label fw-semibold">Ngày bắt đầu bảo hành</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
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
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="warranty_end" class="form-label fw-semibold">Ngày kết thúc bảo hành</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
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

                        <!-- Mô tả -->
                        <div class="mb-4">
                            <textarea 
                                class="form-control" 
                                id="note"
                                wire:model.defer="note"
                                rows="4"
                                placeholder="Ghi chú về linh kiện"
                            ></textarea>
                        </div>

                        <!-- Nút submit -->
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                <i class="fas fa-plus me-2"></i>Thêm mới
                            </button>
                            <button type="button" class="btn btn-secondary btn-lg" onclick="resetForm()">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tự động set ngày bắt đầu bảo hành = ngày nhập kho
    const stockinAtInput = document.getElementById('stockin_at');
    const warrantyStartInput = document.getElementById('warranty_start');
    
    if (stockinAtInput && warrantyStartInput) {
        stockinAtInput.addEventListener('change', function() {
            warrantyStartInput.value = this.value;
        });
    }

    // Xử lý hiển thị/ẩn field bảo hành
    const warrantyCheckbox = document.getElementById('has_warranty');
    const warrantyFields = document.getElementById('warranty-fields');
    
    if (warrantyCheckbox && warrantyFields) {
        warrantyCheckbox.addEventListener('change', function() {
            if (this.checked) {
                warrantyFields.style.display = 'flex';
                // Tự động set ngày bắt đầu bảo hành = ngày nhập kho
                if (stockinAtInput && stockinAtInput.value) {
                    warrantyStartInput.value = stockinAtInput.value;
                }
            } else {
                warrantyFields.style.display = 'none';
            }
        });
    }
});

// Livewire event listener để xử lý khi component được load
document.addEventListener('livewire:load', function() {
    Livewire.hook('message.processed', (message, component) => {
        // Khi Livewire xử lý xong, kiểm tra và set giá trị warranty_start
        const stockinAtInput = document.getElementById('stockin_at');
        const warrantyStartInput = document.getElementById('warranty_start');
        
        if (stockinAtInput && warrantyStartInput && stockinAtInput.value) {
            warrantyStartInput.value = stockinAtInput.value;
        }
    });
});

// Function reset form
function resetForm() {
    // Reset tất cả input fields
    const form = document.querySelector('form');
    if (form) {
        form.reset();
    }
    
    // Set ngày nhập kho về hôm nay
    const stockinAtInput = document.getElementById('stockin_at');
    if (stockinAtInput) {
        const today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
        stockinAtInput.value = today;
    }
    
    // Ẩn field bảo hành
    const warrantyFields = document.getElementById('warranty-fields');
    if (warrantyFields) {
        warrantyFields.style.display = 'none';
    }
    
    // Uncheck checkbox bảo hành
    const warrantyCheckbox = document.getElementById('has_warranty');
    if (warrantyCheckbox) {
        warrantyCheckbox.checked = false;
    }
    
    // Clear Livewire models (nếu cần)
    if (typeof Livewire !== 'undefined') {
        Livewire.emit('resetForm');
    }
}
</script>
