{{-- Header --}}
<div class="card-header bg-main text-white text-center rounded-top-4">
    <h4 class="mb-0">
        <i class="fas fa-qrcode mr-2"></i> Scan code linh kiện
    </h4>
</div>

{{-- Form và Thông tin linh kiện --}}
<div class="row g-4 p-4">
    {{-- Cột Form --}}
    <div class="col-12 p-0">
        {{-- Thông báo --}}
        @if (session('info'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Row --}}
        <div class="d-flex align-items-center gap-3 mb-3">
            {{-- Nút hành động --}}
            <div class="d-flex flex-column flex-sm-row gap-2">
                {{-- Nút quay lại --}}
                <a href="#" class="btn btn-secondary"
                    onclick="Livewire.emit('changeView', 'component-form-scan')">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
                <a href="#" class="btn btn-primary" onclick="Livewire.emit('changeView', 'component-form-scan')">
                    <i class="fas fa-plus me-1"></i> Thêm
                </a>
                <a href="#" class="btn bg-main text-white"
                    onclick="Livewire.emit('scanRequest', 'TPSC-9845-JUH')">
                    <i class="fas fa-qrcode me-1"></i> Scan
                </a>
            </div>

            {{-- Input Serial --}}
            <div class="flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                    <input type="text" name="serial_number" id="serial_number" class="form-control input-hover"
                        value="{{ old('serial_number') }}" placeholder="Nhập số serial (ví dụ: SN123456789)" required
                        autofocus>
                </div>
            </div>
        </div>
    </div>


    {{-- Cột Thông tin linh kiện --}}

    @if (is_object($component))
        <div class="row g-3"> {{-- ✅ Wrap 2 khối vào row mới --}}

            {{-- Thông tin linh kiện --}}
            <div class="col-12 col-lg-6">
                <div class="mt-0 text-gray-600 bg-gray-50 p-3 rounded space-y-1">
                    <div class="d-flex flex-column flex-md-row justify-between gap-4 mb-2">
                        {{-- Bên trái --}}
                        <div class="flex-1 space-y-3 text-[16px]">
                            <p class="font-semibold text-[20px]">
                                <i class="fas fa-barcode mr-1"></i>
                                <span>{{ $component->serial_number ?? 'N/A' }}</span>
                            </p>
                            <p class="font-semibold text-[18px]">
                                <i class="fas fa-memory mr-1 text-blue-600"></i>
                                Tên: <span class="text-gray-700">{{ $component->name }}</span>
                            </p>
                            <p><i class="fas fa-cube mr-1 text-green-600"></i>
                                Loại: <span class="text-gray-700">{{ optional($component->category)->name }}</span>
                            </p>
                            <p><i class="fas fa-shield-alt mr-1 text-purple-600"></i>
                                Bảo hành:
                                @php
                                    $start = \Carbon\Carbon::parse($component->warranty_start);
                                    $end = \Carbon\Carbon::parse($component->warranty_end);
                                    $months = $start->diffInMonths($end);
                                @endphp
                                <strong class="text-gray-700">
                                    {{ $months }} tháng ({{ $start->format('d/m/Y') }} -
                                    {{ $end->format('d/m/Y') }})
                                </strong>
                            </p>
                        </div>

                        {{-- QR Code --}}
                        <div class="w-100 w-md-40 d-flex flex-column align-items-end">
                            <img src="{{ $qrcode ?? asset('img/qrcode-default.jpg') }}" alt="QR Code"
                                class="w-32 h-32 object-contain border rounded shadow p-2" />
                        </div>
                    </div>

                    <hr class="my-3" />

                    {{-- Thông tin thêm --}}
                    <div class="text-md flex-col">
                        <p class="mb-2"><i class="fas fa-layer-group mr-1 text-gray-500"></i> Trạng thái:
                            {{ optional($component->status)->name }}</p>
                        <p class="mb-2"><i class="fas fa-map-marker-alt mr-1 text-gray-500"></i> Vị trí:
                            {{ optional($component->location)->name }}</p>
                        <p class="mb-2"><i class="fas fa-signature mr-1 text-gray-500"></i> Hãng:
                            {{ optional($component->manufacturer)->name }}</p>
                        <p class="mb-2"><i class="fas fa-building mr-1 text-gray-500"></i> Nhà cung cấp:
                            {{ optional($component->vendor)->name }}</p>
                        <p class="mb-2"><i class="fas fa-comment-alt mr-1 text-gray-500"></i> Ghi chú:
                            {{ $component->note }}</p>
                    </div>
                </div>
            </div>

            {{-- Gợi ý tương tự --}}
            <div class="col-12 col-lg-6">
                @if (!empty($suggestions) && count($suggestions))
                    <ul class="space-y-2">
                        <li class="d-flex flex-col gap-2 p-3 bg-gray-100 rounded-md shadow-sm">
                            <h4 class="text-lg font-semibold">
                                <i class="fas fa-list mr-1 text-indigo-500"></i> Các linh kiện tương tự:
                            </h4>
                        </li>

                        <div class="overflow-y-auto" style="max-height: 400px;">
                            @foreach ($suggestions as $item)
                                <li class="d-flex flex-col gap-2 p-3 bg-gray-100 rounded-md shadow-sm">
                                    <div class="d-flex flex-column flex-sm-row gap-2">
                                        <p class="text-sm"><i class="fas fa-barcode mr-1 text-gray-500"></i>
                                            <span class="font-medium text-gray-800">{{ $item->serial_number }}</span>
                                        </p>
                                        <p class="text-sm"><i class="fas fa-microchip mr-1 text-gray-500"></i>
                                            {{ $item->name }}</p>
                                        <p class="text-sm text-gray-500 italic">
                                            Loại: {{ optional($item->category)->name }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-between align-items-center">
                                        @php
                                            $start = \Carbon\Carbon::parse($item->warranty_start);
                                            $end = \Carbon\Carbon::parse($item->warranty_end);
                                            $months = $start->diffInMonths($end);
                                        @endphp
                                        <strong class="text-gray-700 text-sm">
                                            {{ $months }} tháng ({{ $start->format('d/m/Y') }} -
                                            {{ $end->format('d/m/Y') }})
                                        </strong>
                                        <a href="#" class="btn bg-main text-white btn-sm"
                                            onclick="Livewire.emit('scanRequest', '{{ $item->serial_number }}')">
                                            <i class="fas fa-eye me-1"></i> Xem
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </div>
                    </ul>
                @else
                    <p class="text-gray-500 italic text-sm">Không có linh kiện tương tự.</p>
                @endif
            </div>
        </div>
    @else
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded flex items-center gap-2">
            <i class="fas fa-info-circle"></i> Không tìm thấy linh kiện phù hợp với serial đã nhập.
        </div>
    @endif
</div>
