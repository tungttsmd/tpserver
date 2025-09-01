<div class="container-fluid p-3">
    <div class="row">
        <!-- Header với nút và input -->
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">

                    <!-- Nút thêm mới -->
                    <x-atoms.form.button href="{{ route('item.create') }}" label="Thêm mới" />

                    <div class="w-full flex flex-col">
                        <div class="w-full flex gap-2">
                            <!-- Nhóm nút chọn chế độ -->
                            <x-atoms.form.button onclick="Livewire.emit('filter', 'manual')" type="button"
                                class="{{ $filter === 'manual' ? 'font-bold  text-lg' : '' }}" label="Máy quét" />
                            <x-atoms.form.button onclick="Livewire.emit('filter', 'realtime')" type="button"
                                class="{{ $filter === 'realtime' ? 'font-bold text-lg' : '' }}" label="Nhập tay" />
                        </div>
                        <!-- Input tìm kiếm / quét -->
                        @if ($filter === 'realtime')
                            <x-atoms.form.input defer="false" livewire-id="serialNumber" label="Serial number (Nhập tay)"
                                autocomplete="off"/>
                        @elseif ($filter === 'manual')
                            <form id="formTriggerLivewire" wire:submit.prevent="trigger">
                                <x-atoms.form.input livewire-id="serialNumber"
                                    label="Serial number (Máy quét)" form-id="scanInputFocus" autocomplete="off" />
                                <x-atoms.form.button type="submit" hidden />
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

                            @if (is_object($item))
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
                                @if ($component->warranty_start && $component->warranty_end)
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
                                        <i class="fas fa-layer-group me-2"></i>Trạng thái:
                                        {{ optional($component->status)->name }}
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

                                @if ($suggestions->count() > 5)
                                    <div class="card-footer text-center">
                                        <small class="text-muted">Và {{ $suggestions->count() - 5 }} linh kiện
                                            khác...</small>
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
    <script src="{{ asset('js/views/items.scan.js') }}"></script>
    <script>
        const scanManager = new ItemScanView({
            inputId: 'scanInputFocus',
            formId: 'formTriggerLivewire'
        });
    </script>
</div>
