<div class="tpserver stockout container">
    @if (is_object($component))
        {{-- Form xuất kho --}}
        <form wire:submit.prevent='stockout'>
            <div class="overflow-y-auto max-h-[72vh]">
                {{-- Thông tin linh kiện --}}
                <div class="col-lg-12 p-0 overflow-y-auto max-h-[158px]">
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
                <hr>

                <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
                    rel="stylesheet">
                <style>
                    .btn-tab {
                        padding: 0.5rem 1rem !important;
                        /* border-gray-300 */
                        transition: background-color 0.2s !important;
                    }

                    .btn-tab:hover {
                        background-color: #f3f4f6 !important;
                        /* hover:bg-gray-100 */
                    }

                    .btn-tab.active {
                        background-color: #553686 !important;
                        color: white !important;
                        /* text-white */
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1) !important;
                        /* shadow-md */
                    }
                </style>


                <div class="flex gap-3 mb-4 w-full mt-3">
                    <button
                        class="btn-tab rounded-sm bg-success-subtle justify-center flex grow {{ $stockoutType === 'internal' ? 'active' : '' }}"
                        wire:click="setStockoutType('internal')" type="button">
                        <i class="bi bi-box-arrow-in-right mr-3"></i> Xuất kho nội bộ
                    </button>

                    <button
                        class="btn-tab rounded-sm bg-success-subtle justify-center flex grow {{ $stockoutType === 'customer' ? 'active' : '' }}"
                        wire:click="setStockoutType('customer')" type="button">
                        <i class="bi bi-cart-check mr-3"></i> Bán cho khách
                    </button>

                    <button
                        class="btn-tab rounded-sm bg-success-subtle justify-center flex grow {{ $stockoutType === 'vendor' ? 'active' : '' }}"
                        wire:click="setStockoutType('vendor')" type="button">
                        <i class="bi bi-arrow-counterclockwise mr-3"></i> Hoàn trả hàng/sửa chữa
                    </button>
                </div>

                {{-- Ngày xuất kho --}}
                <div class="flex-grow-1" style="min-width: 200px;">
                    <label for="stockout_at" class="form-label">Ngày xuất kho<span class="text-warning">
                            *</span></label>
                    <div class="input-group border-main">
                        <span class="input-group-text border-0" icon-scale border-0"><i
                                class="fas fa-calendar-alt"></i></span>
                        <input wire:model="stockout_at" type="date" class="form-control input-hover border-0"
                            required>
                    </div>
                </div>

                {{-- Nội dung 3 select, chỉ 1 cái hiện --}}
                @if ($stockoutType)
                    {{-- Vendor --}}
                    <div class="mb-3 {{ $stockoutType !== 'vendor' ? 'd-none' : '' }}">
                        <label for="action_id_vendor" class="form-label">Thao tác</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text border-0"><i class="fas fa-paw"></i></span>
                            <select wire:model="action_id" id="action_id" class="form-control input-hover border-0">
                                @foreach ($actionStockoutVendor as $option)
                                    <option value="{{ $option->id }}">{{ $option->note }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 {{ $stockoutType !== 'vendor' ? 'd-none' : '' }}">
                        <label for="action_id_vendor" class="form-label">Nhà cung cấp</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text border-0"><i class="fas fa-paw"></i></span>
                            <select wire:model="vendor_id" id="vendor_id" class="form-control input-hover border-0">
                                @foreach ($vendorOptions as $option)
                                    <option value="{{ $option->id }}">
                                        <strong>{{ $option->name }}</strong>{{ $option->phone ? ' (' . $option->phone . ')' : '' }}.
                                        Email:
                                        <strong> {{ $option->email ?? '---' }} </strong>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Customer --}}
                    <div class="mb-3 {{ $stockoutType !== 'customer' ? 'd-none' : '' }}">
                        <label for="action_id_customer" class="form-label">Thao tác</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text border-0"><i class="fas fa-paw"></i></span>
                            <select wire:model="action_id" id="action_id" class="form-control input-hover border-0">
                                @foreach ($actionStockoutCustomer as $option)
                                    <option value="{{ $option->id }}">{{ $option->note }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 {{ $stockoutType !== 'customer' ? 'd-none' : '' }}">
                        <label for="action_id_customer" class="form-label">Khách hàng</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text border-0"><i class="fas fa-paw"></i></span>
                            <select wire:model="customer_id" id="customer_id"
                                class="form-control input-hover border-0">
                                @foreach ($customerOptions as $option)
                                    <option value="{{ $option->id }}">
                                        <strong>{{ $option->name }}</strong>{{ $option->phone ? ' (' . $option->phone . ')' : '' }}.
                                        Email:
                                        <strong> {{ $option->email ?? '---' }} </strong>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Internal --}}
                    <div class="mb-3 {{ $stockoutType !== 'internal' ? 'd-none' : '' }}">
                        <label for="action_id_internal" class="form-label">Thao tác</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text border-0"><i class="fas fa-paw"></i></span>
                            <select wire:model="action_id" id="action_id" class="form-control input-hover border-0">
                                @foreach ($actionStockoutInternal as $option)
                                    <option value="{{ $option->id }}">{{ $option->note }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 {{ $stockoutType !== 'internal' ? 'd-none' : '' }}">
                        <label for="action_id_internal" class="form-label">Vị trí</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text border-0"><i class="fas fa-paw"></i></span>
                            <select wire:model="location_id" id="location_id"
                                class="form-control input-hover border-0">
                                @foreach ($locationOptions as $option)
                                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <div class="mb-3">
                        <label class="form-label">Thao tác</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text border-0"><i class="fas fa-paw"></i></span>
                            <input class="form-control input-hover border-0" type="text" value="Đã xảy ra lỗi"
                                readonly>
                        </div>
                    </div>
                @endif

                <div class="my-3">
                    <label for="note" class="text-success-subtle form-label pl-3"><strong>Lý do xuất kho (không bắt
                            buộc)</strong></label>
                    <textarea wire:model.defer="note" name="note" id="note"
                        class="border-success-subtle form-control @error('note') is-invalid @enderror" rows="4"
                        placeholder="Nhập lý do xuất kho..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="submit" class="btn bg-success-subtle text-success-subtle">
                    <i class="fas fa-dolly-flatbed mr-2"></i> Xác nhận xuất kho
                </button>
                <button type="button" onclick="closePopup()" class="btn btn-warning">
                    <i class="fas fa-times-circle mr-2"></i> Hủy bỏ
                </button>
            </div>
        </form>
    @else
        <div
            class="h-[78vh] justify-content-center col-lg-12 bg-yellow-100 text-yellow-800 p-3 rounded flex items-center gap-2">
            <i class="fas fa-info-circle"></i> Đã xảy ra sự cố với biểu mẫu xuất kho, xin vui lòng liên hệ quản trị
            viên
            về vấn đề này.
        </div>
    @endif
    <div class="">
        debug:stockout_at:{{ $stockout_at }}stockoutType:{{ $stockoutType }}action_id:{{ $action_id }}component_id:{{ $componentId }}cus:{{ $customer_id }}ven:{{ $vendor_id }}loc:{{ $location_id }}
    </div>
    <script>
        window.addEventListener('closePopup', () => {
            console.log('closePopup event received');
        });
    </script>
</div>
