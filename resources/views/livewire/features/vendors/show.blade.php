@props([
    'data' => $vendor,
    'suggestions' => [],
    'qrcode' => null,
    'filter' => null,
])
<div class="row col-12 overflow-y-auto h-[64vh]"> {{-- ✅ Wrap 2 khối vào row mới --}}
    {{-- Thông tin linh kiện --}}
    <div class="col-lg-12">
        <div class="mt-0 text-gray-600 bg-gray-50 p-3 rounded space-y-1">
            <div class="d-flex flex-column flex-md-row justify-between gap-4 mb-2">
                {{-- Bên trái --}}
                <div class="flex-1 space-y-3 text-[16px]">
                    <p class="font-semibold text-info-dark text-[20px]">
                        <i class="fas fa-barcode mr-1"></i>
                        <span>Đối tác: {{ $data->name ?? 'N/A' }}</span>
                    </p>
                    <p class="font-semibold text-info-subtle text-[18px]">
                        <i class="fas fa-phone mr-1"></i>
                        <span>Số điện thoại: {{ $data->phone ?? 'chưa xác định' }}</span>
                    </p>
                    <p class="font-semibold text-info text-[18px]">
                        <i class="fas fa-envelope mr-1 "></i>
                        <span>Email: {{ $data->email ?? 'chưa xác định' }}</span>
                    </p>
                </div>

                {{-- QR Code --}}
                <div class="w-md-40 d-flex flex-column align-items-center">
                    <div class="relative w-32 h-32">
                        {{-- Ảnh mặc định --}}
                        <img src="{{ asset('img/qrcode-default.jpg') }}" alt="Default QR"
                            class="absolute inset-0 w-full h-full object-contain rounded shadow p-2" />

                        {{-- Ảnh qrcode thật --}}
                        <img src="{{ $data->logo_url ?? 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg' }}" alt="QR Code"
                            class="relative w-full h-full object-contain rounded shadow p-2"
                            />
                    </div>
                </div>
            </div>

            <hr class="my-3" />

            {{-- Thông tin thêm --}}
            <div class="text-md flex-col">
                <p class="mb-2"><i class="fas fa-map-marker-alt mr-1 text-gray-500"></i><strong>Địa chỉ:</strong>
                    {{ $data->address ?? '' }}</p>
                <p class="mb-2"><i class="fas fa-layer-group mr-1 text-gray-500"></i><strong>Ghi chú:</strong>
                    {{ $data->note }}</p>
            </div>
        </div>
    </div>


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
