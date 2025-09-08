<div class="w-[540px]">
    @if (is_object($component))
        <form wire:submit.prevent='stockreturn'>
            <div class="overflow-y-auto max-h-[72vh]">
                {{-- Thông tin linh kiện --}}
                <div class="max-h-[120px] mb-2">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row gap-2">
                            <div class="col-6 w-full truncate">
                                <p class="w-full truncate" style="color: #4b6cb7">
                                    Tên linh kiện: <span class="font-bold">{{ strtoupper($component->name) }}</span>
                                </p>
                                <p class="w-full truncate">
                                    Mã sản phẩm:
                                    <span class="font-bold">{{ data_get($component, 'serial_number') ?? 'N/A' }}</span>
                                </p>
                            </div>
                            <div class="col-6 w-full truncate">
                                <p class="w-full truncate">
                                    Phân loại: <span class="font-bold">{{ optional($component->category)->name }}</span>
                                </p>
                                <p class="w-full truncate">
                                    Nguồn nhập: <span>{{ $component->stockin_source }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="mt-4">
                    {{-- Lý do thu hồi --}}
                    <x-atoms.form.textarea livewire-id="note" form-id="note" placeholder="Nhập lý do thu hồi..." rows="3"
                        class-input="mb-2 border rounded" />
                    {{-- Ngày thu hồi --}}
                    <x-atoms.form.input livewire-id="stockreturn_at" form-id="stockreturn_at" label="Ngày thu hồi"
                        type="date" border="true" required class-input="mb-2 border rounded" />
                </div>
                <div class="flex flex-col gap-2 pt-2">
                    {{-- Thông tin xuất kho --}}
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2">
                            {{-- Loại hành động --}}
                            @php
                                $actionType = match (true) {
                                    isset($lastestComponentLog->customer_id) => [
                                        'label' => 'Bán hàng',
                                        'color' => 'bg-blue-100 text-blue-800',
                                    ],
                                    isset($lastestComponentLog->vendor_id) => [
                                        'label' => 'Hoàn/Sửa/Bảo Hành',
                                        'color' => 'bg-purple-100 text-purple-800',
                                    ],
                                    isset($lastestComponentLog->location_id) => [
                                        'label' => 'Xuất nội bộ',
                                        'color' => 'bg-green-100 text-green-800',
                                    ],
                                    default => ['label' => 'Không xác định', 'color' => 'bg-gray-100 text-gray-800'],
                                };
                            @endphp

                            <div class="text-sm text-gray-700 w-full">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-md font-medium {{ $actionType['color'] }}">
                                    {{ $actionType['label'] }}: {{ $lastestComponentLog->action->note ?? '---' }}
                                </span>
                            </div>
                        </div>
                        {{-- Chi tiết đối tượng --}}
                        @if (isset($lastestComponentLog->customer))
                            <div class="text-sm text-gray-700 w-full">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-md font-medium {{ $actionType['color'] }}">
                                    Khách hàng: {{ $lastestComponentLog->customer->name ?? '---' }}
                                </span>
                            </div>
                        @elseif (isset($lastestComponentLog->location))
                            <div class="text-sm text-gray-700 w-full">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-md font-medium {{ $actionType['color'] }}">
                                    Vị trí: {{ $lastestComponentLog->location->name ?? '---' }}</span>
                            </div>
                        @elseif (isset($lastestComponentLog->vendor))
                            <div class="text-sm text-gray-700 w-full">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-md font-medium {{ $actionType['color'] }}">
                                    Đối tác: {{ $lastestComponentLog->vendor->name ?? '---' }}</span>
                            </div>
                        @endif
                        <hr />
                        <div class="flex items-center gap-2">
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
                            <span class="text-{{$color}}-700"><strong>Bảo hành:</strong> {{ $months }} tháng
                                ({{ $start->format('d/m/Y') }}
                                -
                                {{ $end->format('d/m/Y') }})
                            </span>
                        </div>
                        <hr />
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-700">Ngày nhập:</span>
                            <span class="text-gray-900">
                                {{ $component->stockin_at ? \Carbon\Carbon::parse($component->stockin_at)->format('d/m/Y - h:iA l') : '—' }}
                            </span>
                        </div>
                        <hr />
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-700">Xuất kho gần nhất:</span>
                            <span class="text-gray-900">
                                {{ $lastestComponentLog->stockout_at ? \Carbon\Carbon::parse($lastestComponentLog->stockout_at)->format('d/m/Y - h:iA l') : '—' }}
                                @php
                                    $stockoutDate = $lastestComponentLog->stockout_at
                                        ? \Carbon\Carbon::parse($lastestComponentLog->stockout_at)
                                        : null;
                                    $now = \Carbon\Carbon::now();
                                    if ($stockoutDate) {
                                        $diffInDays = $now->diffInDays($stockoutDate, false);
                                        $color = $diffInDays < 0 ? 'text-red-600' : 'text-green-600';
                                    }
                                @endphp
                            </span>
                        </div>

                        @if ($lastestComponentLog->note)
                            <div class="text-sm items-center gap-2">
                                <span class="font-medium text-gray-700">Lý do xuất kho:</span>
                                <span class="font-normal text-gray-900">{{ $lastestComponentLog->note ?? '—' }}</span>
                            </div>
                        @endif
                        <hr />
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-700">Người thực hiện:</span>
                            <span class="text-gray-900">{{ $lastestComponentLog->user->alias ?? '—' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-700">Ngày thực hiện:</span>
                            <span
                                class="text-gray-900">{{ $lastestComponentLog->created_at ? \Carbon\Carbon::parse($lastestComponentLog->created_at)->format('d/m/Y - h:iA l') : '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4" />
            <div class="flex justify-between gap-3">
                <x-atoms.form.button type="submit" label="Xác nhận thu hồi" color="primary"
                    class="flex-1 py-2 text-sm font-medium" />
                <x-atoms.form.button type="button" label="Hủy bỏ" color="secondary" onclick="closePopup()"
                    class="flex-1 py-2 text-sm font-medium" />
            </div>
        </form>
    @else
        <div class="h-[78vh] flex items-center justify-center text-center">
            <div class="bg-yellow-100 text-yellow-800 p-6 rounded-lg shadow-md">
                <i class="fas fa-exclamation-triangle fa-3x mb-4"></i>
                <h2 class="text-xl font-semibold mb-2">Lỗi tải biểu mẫu</h2>
                <p class="text-gray-700">Đã xảy ra sự cố khi tải biểu mẫu thu hồi. Vui lòng thử lại hoặc liên hệ quản
                    trị viên nếu sự cố vẫn tiếp diễn.</p>
            </div>
        </div>
    @endif
</div>

<script>
    window.addEventListener('closePopup', () => {
        closePopup();
    });
</script>