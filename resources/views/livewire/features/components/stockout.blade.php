<div class="tpserver stockout container">
    @if (is_object($component))
        {{-- Thông tin linh kiện --}}
        <div class="col-lg-12 p-0">
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
                            $months = $start->diffInMonths(date: $end);
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
                    <div class="relative w-32 h-32">
                        {{-- Ảnh mặc định --}}
                        <img src="{{ asset('img/qrcode-default.jpg') }}" alt="Default QR"
                            class="absolute inset-0 w-full h-full object-contain rounded shadow p-2" />

                        {{-- Ảnh qrcode thật --}}
                        <img src="{{ $qrcode }}" alt="QR Code"
                            class="relative w-full h-full object-contain rounded shadow p-2"
                            onload="this.previousElementSibling.style.display='none'" />
                    </div>
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
    @else
        <div
            class="h-[78vh] justify-content-center col-lg-12 bg-yellow-100 text-yellow-800 p-3 rounded flex items-center gap-2">
            <i class="fas fa-info-circle"></i> Không tìm thấy linh kiện phù hợp với serial đã nhập.
        </div>
    @endif

    {{-- Form xuất kho --}}
    <form action="{{ route('components.exportpost', $component->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="my-6">
            <label for="reason" class="form-label pl-3"><strong>Lý do xuất kho <span
                        class="text-warning">*</span></strong></label>
            <textarea name="reason" id="reason" class="border-warning form-control @error('reason') is-invalid @enderror"
                rows="4" placeholder="Nhập lý do xuất kho..." required>{{ old('reason') }}</textarea>
            @error('reason')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check-circle mr-2"></i> Xác nhận xuất kho
            </button>
            <button type="button" class="btn btn-secondary" onclick="history.back()">
                <i class="fas fa-times-circle mr-2"></i> Hủy bỏ
            </button>
        </div>
    </form>

</div>
