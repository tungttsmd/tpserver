<div class="overflow-y-auto">
    @if (is_object($component))
        <div class="flex flex-col gap-2">
            <p style="color: #4b6cb7">
                Tên linh kiện: <span><strong>{{ strtoupper($component->name) }}</strong></span>
            </p>
            <p>
                Mã sản phẩm: <span><strong>{{ data_get($component, 'serial_number') ?? 'N/A' }}</strong></span>
            </p>
            <hr />
            <p>
                Phân loại: <span><strong>{{ optional($component->category)->name }}</strong></span>
            </p>
            <p>
                Trạng thái: <span><strong>{{ optional($component->status)->name }}</strong></span>
            </p>
            <hr />
            <p> Nguồn nhập: <span>{{ $component->stockin_source }}</span></p>
            <hr />
            <p>
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
                <i class="fas fa-shield-alt mr-1 text-{{ $color }}-600"></i>
                <strong class="text-{{ $color }}-700">
                    Bảo hành: {{ $months }} tháng <br> ({{ $start->format('d/m/Y') }} -
                    {{ $end->format('d/m/Y') }})
                </strong>
            </p>
            <p>
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
                <i class="fas fa-clock mr-1 text-{{ $color }}-600"></i>
                <strong class="text-{{ $color }}-700">
                    Nhập kho: {{ $months }} tháng trước ({{ $start->format('d/m/Y') }})
                </strong>
            </p>
            <hr />
            <p>Ghi chú:<br>{{ $component->note }}</p>

            {{-- Slot for additional content --}}
            @if (isset($slot) && trim($slot))
                <hr />
                {{ $slot }}
            @endif
        </div>
    @else
        <div>
            Không tìm thấy dữ liệu
        </div>
    @endif
</div>