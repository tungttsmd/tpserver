<div class="p-6 w-full space-y-6">

    {{-- Cột Form --}}
    <div class="w-full">

        {{-- Thông báo --}}
        @include('livewire.elements.components.alert')

        {{-- Nhóm nút chọn chế độ quét và nút thêm mới --}}
        <div class="flex flex-wrap items-center gap-4 mb-4">

            {{-- Nhóm nút --}}
            <div class="flex space-x-4 items-center">
                <button type="button"
                    class="inline-flex items-center gap-2 rounded bg-green-600 px-4 py-2 text-white text-md font-semibold hover:bg-green-700 transition"
                    onclick="Livewire.emit('route', 'components','create')">
                    <i class="fas fa-plus"></i> Thêm mới
                </button>

                <div class="inline-flex rounded-lg border border-gray-300 overflow-hidden shadow-sm">
                    <a href="#"
                        class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium transition
                        {{ $filter === 'manual' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-primary-50' }}"
                        onclick="Livewire.emit('filter', 'manual')">
                        <i class="fas fa-expand"></i> Máy quét
                    </a>
                    <a href="#"
                        class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium transition
                        {{ $filter === 'realtime' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-primary-50' }}"
                        onclick="Livewire.emit('filter', 'realtime')">
                        <i class="fas fa-barcode"></i> Nhập tay
                    </a>
                </div>
            </div>

            {{-- Input tìm kiếm / quét --}}
            <div class="flex-grow min-w-[220px]" id="scanInputBox">
                @if ($filter === 'realtime')
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none"><i
                                class="fas fa-search"></i></span>
                        <input type="text" wire:model="serialNumber"
                            class="block w-full rounded border border-gray-300 bg-white py-2 pl-10 pr-3 text-gray-900 placeholder-gray-400 focus:border-primary-600 focus:ring-1 focus:ring-primary-600 focus:outline-none sm:text-sm"
                            placeholder="Nhập serial để tra cứu" autocomplete="off" />
                    </div>
                @elseif ($filter === 'manual')
                    <form id="formTriggerLivewire" wire:submit.prevent="trigger" class="relative">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none"><i
                                class="fas fa-barcode"></i></span>
                        <input id="scanInputFocus" type="text" wire:model.defer="serialNumber"
                            class="block w-full rounded border border-gray-300 bg-gray-100 py-2 pl-10 pr-3 text-gray-900 placeholder-gray-500 focus:border-primary-600 focus:ring-1 focus:ring-primary-600 focus:outline-none sm:text-sm"
                            placeholder="Sử dụng máy quét để tra cứu" onfocus="this.select()" />
                        <button type="submit" class="hidden">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>


    </div>

    {{-- Thông tin linh kiện + Gợi ý --}}
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Thông tin linh kiện --}}
        <div class="flex-1 bg-gray-50 rounded-md p-4 shadow-md min-h-[480px]">
            @if (is_object($component))
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row justify-between gap-6 items-start md:items-center">

                        <div class="flex-1 space-y-2">
                            <p class="text-xl font-semibold flex items-center gap-2 text-gray-800">
                                <i class="fas fa-barcode"></i> {{ $component->serial_number ?? 'N/A' }}
                            </p>

                            <p class="text-lg font-semibold text-primary-600 flex items-center gap-2 uppercase">
                                <i class="fas fa-tags"></i> {{ strtoupper($component->name) }}
                            </p>

                            <p class="text-gray-700 flex items-center gap-2">
                                <i class="fas fa-cube text-green-600"></i> Loại:
                                {{ optional($component->category)->name }}
                            </p>

                            @php
                                $start = \Carbon\Carbon::parse($component->warranty_start);
                                $end = \Carbon\Carbon::parse($component->warranty_end);
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

                            <p class="flex items-center gap-2 text-{{ $color }}-600 font-semibold">
                                <i class="fas fa-shield-alt"></i>
                                Bảo hành: {{ $months }} tháng ({{ $start->format('d/m/Y') }} -
                                {{ $end->format('d/m/Y') }})
                            </p>
                            @php
                                $start = \Carbon\Carbon::parse($component->stockin_at);
                                $now = \Carbon\Carbon::now();
                                $months = $start->diffInMonths($now);
                                $color = match (true) {
                                    $months > 12 => 'orange',
                                    $months > 6 => 'yellow',
                                    $months > 3 => 'cyan',
                                    $months > 2 => 'blue',
                                    $months > 1 => 'limes',
                                    $months <= 1 => 'green',
                                    default => 'gray',
                                };
                            @endphp
                            <p class="flex items-center gap-2 text-{{ $color }}-600 font-semibold">
                                <i class="fas fa-truck-moving"></i>
                                Nhập kho: {{ $months }} tháng trước ({{ $start->format('d/m/Y') }})
                            </p>
                        </div>

                        <div class="w-40 h-40 flex items-center justify-center rounded-md bg-white shadow-sm relative">
                            {{-- Ảnh mặc định --}}
                            <img src="{{ asset('img/qrcode-default.jpg') }}" alt="Default QR"
                                class="absolute inset-0 w-full h-full object-contain rounded p-2" />

                            {{-- Ảnh QR thật --}}
                            <img src="{{ $qrcode }}" alt="QR Code"
                                class="relative w-full h-full object-contain rounded p-2"
                                onload="this.previousElementSibling.style.display='none'" />
                        </div>
                    </div>

                    <hr class="border-gray-300" />

                    {{-- Thông tin chi tiết --}}
                    <div class="space-y-2 text-gray-700">
                        <p><i class="fas fa-layer-group mr-2 text-gray-400"></i> Trạng thái:
                            {{ optional($component->status)->name }}</p>
                        <p><i class="fas fa-signature mr-2 text-gray-400"></i> Hãng:
                            {{ optional($component->manufacturer)->name }}</p>
                        <p><i class="fas fa-building mr-2 text-gray-400"></i> Nguồn nhập:
                            {{ $component->stockin_source }}</p>
                        <p><i class="fas fa-comment-alt mr-2 text-gray-400"></i> Ghi chú: {{ $component->note }}</p>
                    </div>
                </div>
            @else
                @if ($serialNumber)
                    <div
                        class="flex items-center justify-center min-h-[300px] bg-yellow-100 text-yellow-800 rounded-md p-4 text-center text-lg font-medium gap-2">
                        <i class="fas fa-info-circle text-yellow-600"></i>
                        Không tìm thấy linh kiện phù hợp với serial đã nhập.
                    </div>
                @endif
            @endif
        </div>

        {{-- Gợi ý linh kiện tương tự --}}
        <div class="col-6">
            @if ($suggestions)
                @if ($suggestions->count())
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <i class="fas fa-boxes text-gray-400 w-5 h-5"></i>
                        Các linh kiện tương tự:
                    </h4>

                    <div class="overflow-y-auto max-h-[68vh] border border-gray-200 rounded-lg bg-white shadow-sm">
                        <ul role="list" class="divide-y divide-gray-100">
                            @foreach ($suggestions as $item)
                                <li class="px-4 py-3 flex flex-col gap-2 hover:bg-gray-50 transition">
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-500 italic flex items-center gap-2">
                                            <i class="fas fa-barcode text-gray-400 w-4 h-4"></i>
                                            <strong>{{ $item->serial_number }}</strong>
                                        </p>

                                        <p
                                            class="text-sm font-semibold text-primary-700 flex items-center gap-1 uppercase">
                                            {{ $item->name }}
                                            <i class="fas fa-tags text-primary-500 w-4 h-4"></i>
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap gap-4 text-sm italic">
                                        <p class="flex items-center gap-1 text-green-600">
                                            <i class="fas fa-cube w-4 h-4"></i>
                                            Loại: {{ optional($item->category)->name ?? '-' }}
                                        </p>
                                        <p class="flex items-center gap-1 text-blue-600">
                                            <i class="fas fa-layer-group w-4 h-4"></i>
                                            Trạng thái: {{ optional($item->status)->name ?? '-' }}
                                        </p>
                                        <p class="flex items-center gap-1 text-orange-500">
                                            <i class="fas fa-file-import w-4 h-4"></i>
                                            Nhập kho: {{ $item->stockin_at ?? 'N/A' }}
                                        </p>
                                    </div>

                                    <div class="flex justify-between items-center mt-1">
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

                                        <span
                                            class="text-{{ $color }}-700 font-semibold flex items-center gap-1">
                                            <i class="fas fa-shield-alt text-{{ $color }}-600 w-5 h-5"></i>
                                            Bảo hành: {{ $months }} tháng ({{ $start->format('d/m/Y') }} -
                                            {{ $end->format('d/m/Y') }})
                                        </span>

                                        @if ($filter === 'manual')
                                            <button type="button"
                                                class="text-primary-600 hover:text-primary-800 flex items-center gap-1"
                                                onclick="triggerManualScan('{{ $item->serial_number }}')">
                                                <i class="fas fa-eye w-5 h-5"></i>
                                                Xem
                                            </button>
                                        @else
                                            <button type="button"
                                                class="text-primary-600 hover:text-primary-800 flex items-center gap-1"
                                                onclick="triggerRealtimeScan('{{ $item->serial_number }}')">
                                                <i class="fas fa-eye w-5 h-5"></i>
                                                Xem
                                            </button>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-4">
                        {{ $suggestions->links('livewire.elements.components.arrow-paginator') }}
                    </div>
                @else
                    <p class="text-gray-400 italic text-center py-6">Không có linh kiện tương tự.</p>
                @endif
            @endif
        </div>




    </div>

</div>
