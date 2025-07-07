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
                    <i class="fas fa-arrow-left "></i> Quay lại
                </a>
                <a href="#" class="btn btn-primary" onclick="Livewire.emit('changeView', 'component-form-scan')">
                    <i class="fas fa-plus "></i> Thêm
                </a>
                <a href="#" class="btn bg-main text-white"
                    onclick="Livewire.emit('scanRequest', 'TPSC-0173-KOD')">
                    <i class="fas fa-qrcode "></i> Scan
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

    <div class="row col-12 g-3"> {{-- ✅ Wrap 2 khối vào row mới --}}
        @if (is_object($component))
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
                            <p class="font-semibold text-[18px]" style="color: #4b6cb7">
                                <i class="fas fa-tags mr-1"></i>
                                <span>{{ strtoupper($component->name) }}</span>
                            </p>
                            <p>
                                <i class="fas fa-cube mr-1 text-green-600"></i>
                                Loại: <span class="text-gray-700">{{ optional($component->category)->name }}</span>
                            </p>
                            <p>

                                @php
                                    $start = \Carbon\Carbon::parse($component->warranty_start);
                                    $end = \Carbon\Carbon::parse($component->warranty_end);
                                    $months = $start->diffInMonths($end);
                                    $color = match (true) {
                                        $months <= 0 => 'red',
                                        $months > 48 => 'purple', // tím
                                        $months > 36 => 'indigo', // chàm
                                        $months > 24 => 'blue', // lam
                                        $months > 12 => 'green', // lục
                                        $months > 6 => 'yellow', // vàng
                                        $months > 3 => 'orange', // cam
                                        default => 'gray', // fallback
                                    };
                                @endphp
                                <i class="fas fa-shield-alt mr-1 text-{{ $color }}-600"></i>

                                <strong class="text-{{ $color }}-700">
                                    Bảo hành: {{ $months }} tháng ({{ $start->format('d/m/Y') }} -
                                    {{ $end->format('d/m/Y') }})
                                </strong>
                            </p>
                        </div>

                        {{-- QR Code --}}
                        <div class="w-md-40 d-flex flex-column align-items-center">
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
        @else
            <div
                class="justify-content-center col-lg-6 bg-yellow-100 text-yellow-800 p-3 rounded flex items-center gap-2">
                <i class="fas fa-info-circle"></i> Không tìm thấy linh kiện phù hợp với serial đã nhập.
            </div>
        @endif
        @include('livewire.partials.component-form-scan-suggestion')
    </div>

</div>
