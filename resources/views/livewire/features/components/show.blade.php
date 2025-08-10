    <div class="row col-12 overflow-y-auto h-[64vh]"> {{-- ✅ Wrap 2 khối vào row mới --}}
        {{-- Cột Thông tin linh kiện --}}
        @if (is_object($component))
            {{-- Thông tin linh kiện --}}
            <div class="col-lg-12">
                <div class="mt-0 text-gray-600 bg-gray-50 p-3 rounded space-y-1">
                    <div class="d-flex flex-column flex-md-row justify-between gap-4 mb-2">
                        {{-- Bên trái --}}
                        <div class="flex-1 space-y-3 text-[16px]">
                            <p class="font-semibold text-[20px]">
                                <i class="fas fa-barcode mr-1"></i>
                                <span>{{ data_get($this->component, 'serial_number') ?? 'N/A' }}</span>
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
            </div>
        @else
            <div
                class="h-[78vh] justify-content-center col-lg-12 bg-yellow-100 text-yellow-800 p-3 rounded flex items-center gap-2">
                <i class="fas fa-info-circle"></i> Không tìm thấy linh kiện phù hợp với serial đã nhập.
            </div>
        @endif

        {{-- Nội dung gợi ý tìm kiếm --}}
        {{-- Gợi ý tương tự --}}
        <div class="col-lg-12">
            @if ($suggestions)
                @if (count($suggestions))
                    <h4 class="mt-3 text-md font-semibold text-gray-500 mb-2">
                        <i class="fas fa-list mr-1 text-gray-500"></i> Các linh kiện tương tự:
                    </h4>

                    <div class="overflow-y-auto h-[44vh]">
                        <ul class="space-y-2">
                            @foreach ($suggestions as $item)
                                <li class="mt-2 d-flex flex-col gap-2 p-2 bg-gray-100 rounded shadow-sm">
                                    <div class="d-inline-flex justify-content-between">
                                        <p class="mr-2 text-sm flex items-center text-gray-500 italic"><i
                                                class="fas fa-barcode mr-2 text-gray-500"></i>
                                            <span
                                                class="font-medium text-gray-500"><strong>{{ $item->serial_number }}</strong></span>
                                        </p>
                                        <p class="text-sm text-blue-700" style="color: #4b6cb7">
                                            <strong>{{ strtoupper($item->name) }}</strong><i
                                                class="fas fa-tags ml-2 text-blue-500" style="color: #4b6cb7"></i>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between flex-column flex-sm-row gap-2">

                                        <div class="d-inline-flex flex">

                                            <p class="mr-2 text-sm flex items-center text-green-500 italic"><i
                                                    class="fas fa-cube mr-1 text-green-500"></i>
                                                Loại: {{ optional($item->category)->name }}
                                            </p>
                                            <p class="mr-2 text-sm flex items-center text-blue-500 italic"><i
                                                    class="fas fa-layer-group mr-1 text-blue-500"></i>
                                                Trạng thái: {{ optional($item->status)->name }}
                                            </p>
                                            <p class="mr-2 text-sm flex items-center text-orange-500 italic"><i
                                                    class="fas fa-file-import mr-1 text-orange-500"></i>
                                                Nhập kho: {{ $item->stockin_at ?? 'N/A' }}
                                            </p>
                                        </div>

                                    </div>
                                    <div class="d-flex justify-between align-items-center">
                                        @php
                                            $start = \Carbon\Carbon::parse($item->warranty_start);
                                            $end = \Carbon\Carbon::parse($item->warranty_end);
                                            $months = $start->diffInMonths($end);
                                            $color = match (true) {
                                                $months <= 0 => 'red',
                                                $months > 48 => 'purple',
                                                $months > 36 => 'indigo',
                                                $months > 24 => 'blue',
                                                $months > 12 => 'green',
                                                $months > 6 => 'yellow',
                                                $months > 3 => 'orange',
                                                default => 'gray',
                                            };
                                        @endphp
                                        <strong class="text-{{ $color }}-700">
                                            <i class="fas fa-shield-alt mr-1 text-{{ $color }}-600"></i>
                                            Bảo hành: {{ $months }} tháng ({{ $start->format('d/m/Y') }} -
                                            {{ $end->format('d/m/Y') }})
                                        </strong>

                                        @if ($filter === 'manual')
                                            <a href="#" class="text-main bright-hover scale-hover"
                                                onclick="triggerManualScan('{{ $item->serial_number }}')">
                                                <i class="fas fa-eye m-0"></i> Xem
                                            </a>
                                        @else
                                            <a href="#" class="text-main bright-hover scale-hover"
                                                onclick="triggerRealtimeScan('{{ $item->serial_number }}')">
                                                <i class="fas fa-eye m-0"></i> Xem
                                            </a>
                                        @endif
                                    </div>

                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-2">
                        {{ $suggestions->links('livewire.elements.components.arrow-paginator') }}
                    </div>
                @else
                    <p class="text-gray-500 italic text-md ml-4">Không có linh kiện tương tự.</p>
                @endif
            @endif
        </div>

    </div>
