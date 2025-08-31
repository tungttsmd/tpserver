<div class="container-fluid p-3">
    <div class="row">
        <!-- Header với nút và input -->
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <!-- Thông báo -->
                    @include('livewire.components.alert')

                    <!-- Nhóm nút chọn chế độ -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                        <!-- Nút thêm mới -->
                        <button type="button" class="btn btn-success" 
                            onclick="Livewire.emit('route', 'components','create')">
                            <i class="fas fa-plus me-2"></i>Thêm mới
                        </button>

                        <!-- Toggle chế độ quét -->
                        <div class="btn-group">
                            <button type="button" class="btn {{ $filter === 'manual' ? 'btn-primary active' : 'btn-outline-primary' }}"
                                onclick="Livewire.emit('filter', 'manual')">
                                <i class="fas fa-barcode me-2"></i>Máy quét
                            </button>
                            <button type="button" class="btn {{ $filter === 'realtime' ? 'btn-primary active' : 'btn-outline-primary' }}"
                                onclick="Livewire.emit('filter', 'realtime')">
                                <i class="fas fa-keyboard me-2"></i>Nhập tay
                            </button>
                        </div>
                    </div>

                    <!-- Input tìm kiếm / quét -->
                    <div class="input-group" id="scanInputBox">
                        @if ($filter === 'realtime')
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" wire:model="serialNumber" class="form-control"
                                placeholder="Nhập serial để tra cứu" autocomplete="off" />
                        @elseif ($filter === 'manual')
                            <form id="formTriggerLivewire" wire:submit.prevent="trigger">
                                <span class="input-group-text">
                                    <i class="fas fa-barcode"></i>
                                </span>
                                <input id="scanInputFocus" type="text" wire:model.defer="serialNumber"
                                    class="form-control" placeholder="Sử dụng máy quét để tra cứu" 
                                    onfocus="this.select()" />
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Nội dung chính -->
        <div class="col-12">
            <div class="row g-3">
                <!-- Thông tin linh kiện -->
                <div class="col-12 col-lg-8">
                    <div class="card h-100">
                        <div class="card-body">
                            @if (is_object($component))
                                <div class="mb-3">
                                    <h5 class="text-primary fw-bold mb-2">
                                        <i class="fas fa-barcode me-2"></i>{{ $component->serial_number ?? 'N/A' }}
                                    </h5>
                                    <h6 class="text-dark fw-semibold mb-2">
                                        <i class="fas fa-tags me-2"></i>{{ strtoupper($component->name) }}
                                    </h6>
                                    <p class="text-muted mb-1">
                                        <i class="fas fa-cube me-2"></i>Loại: {{ optional($component->category)->name }}
                                    </p>
                                </div>

                                <!-- Bảo hành -->
                                @if($component->warranty_start && $component->warranty_end)
                                    @php
                                        $start = \Carbon\Carbon::parse($component->warranty_start);
                                        $end = \Carbon\Carbon::parse($component->warranty_end);
                                        $months = $start->diffInMonths($end);
                                        $color = match (true) {
                                            $months <= 0 => 'danger',
                                            $months > 48 => 'purple',
                                            $months > 36 => 'info',
                                            $months > 24 => 'primary',
                                            $months > 12 => 'success',
                                            $months > 6 => 'warning',
                                            $months > 3 => 'orange',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <div class="alert alert-{{ $color }} py-2 mb-3">
                                        <i class="fas fa-shield-alt me-2"></i>
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
