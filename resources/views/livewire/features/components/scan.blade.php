<style>
/* Import CSS chung */
@import url('{{ asset("resources/views/livewire/features/components/common.css") }}');

/* CSS riêng cho scan component */
.scan-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem;
}

.scan-header {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.scan-header-body {
    padding: 2rem;
}

.scan-controls {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.scan-mode-toggle {
    display: flex;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    overflow: hidden;
}

.scan-mode-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    background: #fff;
    color: #6b7280;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.scan-mode-btn.active {
    background: #3b82f6;
    color: #fff;
}

.scan-mode-btn:hover:not(.active) {
    background: #f9fafb;
}

.scan-input-container {
    margin-top: 1rem;
}

.scan-form {
    display: flex;
    gap: 0.5rem;
}

.scan-form .input-group {
    flex: 1;
}

.scan-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
}

.component-info {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.component-info-header {
    background: #f8fafc;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.component-info-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.component-info-body {
    padding: 2rem;
}

.warranty-alert {
    margin: 1rem 0;
    padding: 1rem 1.5rem;
    border-radius: 6px;
    border: 1px solid;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.warranty-alert.success {
    background: #f0fdf4;
    border-color: #bbf7d0;
    color: #166534;
}

.warranty-alert.warning {
    background: #fffbeb;
    border-color: #fed7aa;
    color: #d97706;
}

.warranty-alert.danger {
    background: #fef2f2;
    border-color: #fecaca;
    color: #dc2626;
}

.warranty-alert.info {
    background: #eff6ff;
    border-color: #bfdbfe;
    color: #2563eb;
}

.qr-section {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    height: fit-content;
}

.qr-container {
    position: relative;
    width: 200px;
    height: 200px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
}

.qr-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 0.5rem;
}

.qr-fallback {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 0.5rem;
}

.qr-real {
    position: relative;
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 0.5rem;
}

.empty-state {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 3rem 2rem;
    background: #fef3c7;
    color: #92400e;
    border-radius: 8px;
    font-weight: 600;
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .scan-container {
        padding: 1rem;
    }
    
    .scan-header-body {
        padding: 1.5rem;
    }
    
    .scan-controls {
        flex-direction: column;
        align-items: stretch;
    }
    
    .scan-mode-toggle {
        justify-content: center;
    }
    
    .scan-content {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .qr-container {
        width: 150px;
        height: 150px;
    }
}
</style>

<div class="scan-container">
    <!-- Header với controls -->
    <div class="scan-header">
        <div class="scan-header-body">
            <!-- Thông báo -->
            @include('livewire.components.alert')

            <!-- Controls -->
            <div class="scan-controls">
                <!-- Nút thêm mới -->
                <button type="button" class="btn btn-success" 
                    onclick="Livewire.emit('route', 'components','create')">
                    <i class="fas fa-plus"></i>
                    Thêm mới
                </button>

                <!-- Toggle chế độ quét -->
                <div class="scan-mode-toggle">
                    <button type="button" class="scan-mode-btn {{ $filter === 'manual' ? 'active' : '' }}"
                        onclick="Livewire.emit('filter', 'manual')">
                        <i class="fas fa-barcode"></i>
                        Máy quét
                    </button>
                    <button type="button" class="scan-mode-btn {{ $filter === 'realtime' ? 'active' : '' }}"
                        onclick="Livewire.emit('filter', 'realtime')">
                        <i class="fas fa-keyboard"></i>
                        Nhập tay
                    </button>
                </div>
            </div>

            <!-- Input tìm kiếm / quét -->
            <div class="scan-input-container">
                @if ($filter === 'realtime')
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" wire:model="serialNumber" class="form-control"
                            placeholder="Nhập serial để tra cứu" autocomplete="off" />
                    </div>
                @elseif ($filter === 'manual')
                    <form id="formTriggerLivewire" wire:submit.prevent="trigger" class="scan-form">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-barcode"></i>
                            </span>
                            <input id="scanInputFocus" type="text" wire:model.defer="serialNumber"
                                class="form-control" placeholder="Sử dụng máy quét để tra cứu" 
                                onfocus="this.select()" />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Nội dung chính -->
    <div class="scan-content">
        <!-- Thông tin linh kiện -->
        <div class="component-info">
            @if (is_object($component))
                <div class="component-info-header">
                    <h2 class="component-info-title">
                        <i class="fas fa-cube"></i>
                        Thông tin linh kiện
                    </h2>
                </div>
                
                <div class="component-info-body">
                    <div class="info-section">
                        <!-- Serial Number -->
                        <div class="info-item">
                            <div class="info-icon" style="background: #dbeafe; color: #1e40af;">
                                <i class="fas fa-barcode"></i>
                            </div>
                            <span class="info-label">Serial Number:</span>
                            <span class="info-value primary">{{ $component->serial_number ?? 'N/A' }}</span>
                        </div>

                        <!-- Tên linh kiện -->
                        <div class="info-item">
                            <div class="info-icon" style="background: #e0e7ff; color: #3730a3;">
                                <i class="fas fa-tags"></i>
                            </div>
                            <span class="info-label">Tên linh kiện:</span>
                            <span class="info-value primary">{{ strtoupper($component->name) }}</span>
                        </div>

                        <!-- Phân loại -->
                        <div class="info-item">
                            <div class="info-icon" style="background: #dcfce7; color: #166534;">
                                <i class="fas fa-cube"></i>
                            </div>
                            <span class="info-label">Phân loại:</span>
                            <span class="info-value">{{ optional($component->category)->name ?? 'N/A' }}</span>
                        </div>

                        <!-- Bảo hành -->
                        @if($component->warranty_start && $component->warranty_end)
                            @php
                                $start = \Carbon\Carbon::parse($component->warranty_start);
                                $end = \Carbon\Carbon::parse($component->warranty_end);
                                $months = $start->diffInMonths($end);
                                $color = match (true) {
                                    $months <= 0 => 'danger',
                                    $months > 48 => 'info',
                                    $months > 36 => 'info',
                                    $months > 24 => 'info',
                                    $months > 12 => 'success',
                                    $months > 6 => 'warning',
                                    $months > 3 => 'warning',
                                    default => 'info',
                                };
                            @endphp
                            <div class="warranty-alert {{ $color }}">
                                <i class="fas fa-shield-alt"></i>
                                <strong>Bảo hành:</strong> {{ $months }} tháng 
                                ({{ $start->format('d/m/Y') }} - {{ $end->format('d/m/Y') }})
                            </div>
                        @endif

                                <!-- Thông tin chi tiết -->
                                <div class="row g-2 text-muted small">
                                    <div class="col-6">
                                        <i class="fas fa-layer-group me-2"></i>Trạng thái: {{ optional($component->status)->name }}
                                    </div>
                                    <div class="col-6">
                                        <i class="fas fa-comment me-2"></i>Ghi chú: {{ $component->note }}
                                    </div>
                                </div>
                            @else
                                @if ($serialNumber)
                                    <div class="text-center py-5">
                                        <i class="fas fa-info-circle fa-3x text-warning mb-3"></i>
                                        <h5 class="text-warning">Không tìm thấy linh kiện</h5>
                                        <p class="text-muted">Serial: {{ $serialNumber }}</p>
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="fas fa-search fa-3x mb-3"></i>
                                        <h5>Nhập serial để tra cứu</h5>
                                        <p>Hoặc sử dụng máy quét barcode</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Gợi ý linh kiện tương tự -->
                <div class="col-12 col-lg-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-boxes me-2"></i>Linh kiện tương tự
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            @if ($suggestions && $suggestions->count())
                                <div class="list-group list-group-flush">
                                    @foreach ($suggestions->take(5) as $item)
                                        <div class="list-group-item border-0 py-2">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <small class="text-muted fw-bold">{{ $item->serial_number }}</small>
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    onclick="triggerManualScan('{{ $item->serial_number }}')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="small text-muted">
                                                <div class="fw-semibold">{{ $item->name }}</div>
                                                <div>Loại: {{ optional($item->category)->name }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @if($suggestions->count() > 5)
                                    <div class="card-footer text-center">
                                        <small class="text-muted">Và {{ $suggestions->count() - 5 }} linh kiện khác...</small>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-box-open fa-2x mb-2"></i>
                                    <p class="small">Không có linh kiện tương tự</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Function để xem component - Manual scan
function triggerManualScan(serialNumber) {
    Livewire.emit('filter', 'manual');
    setTimeout(() => {
        document.getElementById('scanInputFocus').value = serialNumber;
        document.getElementById('formTriggerLivewire').dispatchEvent(new Event('submit'));
    }, 100);
}

// Function để xem component - Realtime scan
function triggerRealtimeScan(serialNumber) {
    Livewire.emit('filter', 'realtime');
    setTimeout(() => {
        // Cập nhật input realtime
        if (typeof Livewire !== 'undefined') {
            Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).set('serialNumber', serialNumber);
        }
    }, 100);
}

// Auto focus cho input scan
document.addEventListener('DOMContentLoaded', function() {
    const scanInput = document.getElementById('scanInputFocus');
    if (scanInput) scanInput.focus();
});

// Livewire event listener
document.addEventListener('livewire:load', function() {
    Livewire.hook('message.processed', (message, component) => {
        const scanInput = document.getElementById('scanInputFocus');
        if (scanInput && document.getElementById('scanInputBox').style.display !== 'none') {
            scanInput.focus();
        }
    });
});
</script>
