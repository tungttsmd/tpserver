<style>
/* CSS tối giản cho components */
.component-show {
    max-width: 1000px;
    margin: 0 auto;
    padding: 1.5rem;
}

.show-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.show-header {
    background: #f8fafc;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.show-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.show-body {
    padding: 2rem;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 2rem;
    align-items: start;
}

.info-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.info-item:last-child {
    border-bottom: none;
}

.info-icon {
    width: 1.5rem;
    height: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    font-size: 0.875rem;
}

.info-label {
    font-weight: 600;
    color: #6b7280;
    min-width: 120px;
}

.info-value {
    font-weight: 500;
    color: #1f2937;
    flex: 1;
}

.info-value.primary {
    font-weight: 700;
    color: #1e40af;
}

.info-value.success {
    font-weight: 600;
    color: #059669;
}

.info-value.warning {
    font-weight: 600;
    color: #d97706;
}

.info-value.danger {
    font-weight: 600;
    color: #dc2626;
}

.qr-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.qr-container {
    position: relative;
    width: 150px;
    height: 150px;
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

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-badge.success {
    background: #dcfce7;
    color: #166534;
}

.status-badge.warning {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.danger {
    background: #fee2e2;
    color: #991b1b;
}

.status-badge.info {
    background: #dbeafe;
    color: #1e40af;
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
}

/* Responsive */
@media (max-width: 768px) {
    .component-show {
        padding: 1rem;
    }
    
    .show-body {
        padding: 1.5rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .qr-section {
        order: -1;
    }
    
    .qr-container {
        width: 120px;
        height: 120px;
    }
}
</style>

<div class="component-show">
    <div class="show-card">
        @if (is_object($component))
            <div class="show-header">
                <h1 class="show-title">
                    <i class="fas fa-cube"></i>
                    Thông tin linh kiện
                </h1>
            </div>
            
            <div class="show-body">
                <div class="info-grid">
                    <div class="info-section">
                        <!-- Serial Number -->
                        <div class="info-item">
                            <div class="info-icon" style="background: #dbeafe; color: #1e40af;">
                                <i class="fas fa-barcode"></i>
                            </div>
                            <span class="info-label">Serial Number:</span>
                            <span class="info-value primary">{{ data_get($this->component, 'serial_number') ?? 'N/A' }}</span>
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
                        <div class="info-item">
                            @php
                                $start = \Carbon\Carbon::parse($component->warranty_start);
                                $end = \Carbon\Carbon::parse($component->warranty_end);
                                $months = $start->diffInMonths(date: $end);
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
                            <div class="info-icon" style="background: {{ $color === 'danger' ? '#fee2e2' : ($color === 'success' ? '#dcfce7' : ($color === 'warning' ? '#fef3c7' : '#dbeafe')) }}; color: {{ $color === 'danger' ? '#991b1b' : ($color === 'success' ? '#166534' : ($color === 'warning' ? '#92400e' : '#1e40af')) }};">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <span class="info-label">Bảo hành:</span>
                            <span class="info-value {{ $color }}">
                                {{ $months }} tháng ({{ $start->format('d/m/Y') }} - {{ $end->format('d/m/Y') }})
                            </span>
                        </div>

                        <!-- Ngày nhập kho -->
                        <div class="info-item">
                            @php
                                $start = \Carbon\Carbon::parse($component->stockin_at);
                                $now = \Carbon\Carbon::now();
                                $months = $start->diffInMonths($now);
                                $color = match (true) {
                                    $months > 12 => 'warning',
                                    $months > 6 => 'warning',
                                    $months > 3 => 'info',
                                    $months > 2 => 'info',
                                    $months > 1 => 'success',
                                    $months <= 1 => 'success',
                                    default => 'info',
                                };
                            @endphp
                            <div class="info-icon" style="background: {{ $color === 'success' ? '#dcfce7' : ($color === 'warning' ? '#fef3c7' : '#dbeafe') }}; color: {{ $color === 'success' ? '#166534' : ($color === 'warning' ? '#92400e' : '#1e40af') }};">
                                <i class="fas fa-truck-moving"></i>
                            </div>
                            <span class="info-label">Nhập kho:</span>
                            <span class="info-value {{ $color }}">
                                {{ $months }} tháng trước ({{ $start->format('d/m/Y') }})
                            </span>
                        </div>

                        <!-- Trạng thái -->
                        <div class="info-item">
                            <div class="info-icon" style="background: #f3f4f6; color: #6b7280;">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <span class="info-label">Trạng thái:</span>
                            <span class="info-value">{{ optional($component->status)->name ?? 'N/A' }}</span>
                        </div>

                        <!-- Hãng sản xuất -->
                        <div class="info-item">
                            <div class="info-icon" style="background: #f3f4f6; color: #6b7280;">
                                <i class="fas fa-signature"></i>
                            </div>
                            <span class="info-label">Hãng sản xuất:</span>
                            <span class="info-value">{{ optional($component->manufacturer)->name ?? 'N/A' }}</span>
                        </div>

                        <!-- Nguồn nhập -->
                        <div class="info-item">
                            <div class="info-icon" style="background: #f3f4f6; color: #6b7280;">
                                <i class="fas fa-building"></i>
                            </div>
                            <span class="info-label">Nguồn nhập:</span>
                            <span class="info-value">{{ $component->stockin_source ?? 'N/A' }}</span>
                        </div>

                        <!-- Ghi chú -->
                        @if($component->note)
                        <div class="info-item">
                            <div class="info-icon" style="background: #f3f4f6; color: #6b7280;">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <span class="info-label">Ghi chú:</span>
                            <span class="info-value">{{ $component->note }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- QR Code -->
                    <div class="qr-section">
                        <div class="qr-container">
                            <!-- Ảnh mặc định -->
                            <img src="{{ asset('img/qrcode-default.jpg') }}" alt="Default QR"
                                class="qr-fallback" />

                            <!-- Ảnh qrcode thật -->
                            <img src="{{ $qrcode }}" alt="QR Code"
                                class="qr-real"
                                onload="this.previousElementSibling.style.display='none'" />
                        </div>
                        <span class="status-badge success">
                            <i class="fas fa-qrcode"></i>
                            QR Code
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-info-circle"></i>
                Không tìm thấy linh kiện phù hợp với serial đã nhập.
            </div>
        @endif
    </div>
</div>
