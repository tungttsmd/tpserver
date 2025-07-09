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
        <div class="row mb-3 gx-3 align-items-center">
            {{-- Nhóm nút --}}
            <div class="col-auto">
                <div class="btn-group btn-group-sm mb-2" role="group" aria-label="Chọn chế độ quét">
                    <button type="button" class="d-inline-flex align-items-center btn btn-success rounded text-md"
                        onclick="Livewire.emit('changeView', 'component-form-create')">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                    <div class="ml-4 rounded-lg  overflow-hidden border g-0 d-inline-flex   ">
                        <a href="#"
                            class="btn rounded-0 {{ $mode === 'manual' ? 'bg-main text-white border-1 ' : 'bg-light text-dark ' }}"
                            onclick="Livewire.emit('setScanModeRequest', 'manual')">
                            <i class="fas fa-expand"></i> Máy quét
                        </a>
                        <a href="#"
                            class="btn rounded-0 {{ $mode === 'realtime' ? 'bg-main text-white border-1 ' : 'bg-light text-dark ' }}"
                            onclick="Livewire.emit('setScanModeRequest', 'realtime')">
                            <i class="fas fa-barcode"></i> Nhập tay
                        </a>
                    </div>
                </div>
            </div>

            {{-- Ô input --}}
            <div class="col" id="scanInputBox">
                @if ($mode === 'realtime')
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" wire:model="serialNumber" class="form-control"
                            placeholder="Nhập serial để tra cứu" autocomplete="off" />
                    </div>
                @elseif ($mode === 'manual')
                    <form id="formTriggerLivewire" wire:submit.prevent="formRenderTrigger">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            <input id="scanInputFocus" type="text" wire:model.defer="serialNumber"
                                class="form-control" placeholder="Sử dụng máy quét để tra cứu" onfocus="this.select()"
                                style="background-color: #e9ecef">
                            <button type="submit" class="btn btn-primary" hidden>
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                @endif
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
            </div>
        @else
            @if ($serialNumber)
                <div
                    class="justify-content-center col-lg-6 bg-yellow-100 text-yellow-800 p-3 rounded flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> Không tìm thấy linh kiện phù hợp với serial đã nhập.
                </div>
            @endif
        @endif
        @include('livewire.partials.component-form-scan-suggestion')
    </div>

</div>
