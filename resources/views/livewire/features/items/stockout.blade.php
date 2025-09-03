<div class="w-[540px]">
    @if (is_object($component))
        {{-- Form xuất kho --}}
        <form wire:submit.prevent='stockout'>
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
                        <hr />
                        <div class="flex flex-row gap-2">
                            <div class="col-6 w-full ">
                                <p class="w-full ">
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
                                        Bảo hành: {{ $months }} tháng <br> ({{ $start->format('d/m/Y') }}
                                        -
                                        {{ $end->format('d/m/Y') }})
                                    </strong>
                                </p>
                            </div>
                            <div class="col-6 w-full ">
                                <p class="w-full ">
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
                                        Nhập kho: {{ $months }} tháng trước
                                        ({{ $start->format('d/m/Y') }})
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />

                <div class="flex flex-col gap-2 pt-6">
                    {{-- Lí do xuất kho --}}
                    <x-atoms.form.textarea livewire-id="note" form-id="note" placeholder="Nhập lý do xuất kho..."
                        border="true" />
                    {{-- Ngày xuất kho --}}
                    <x-atoms.form.input livewire-id="stockout_at" form-id="stockout_at" label="Ngày xuất kho"
                        type="date" required class-input="border rounded" />
                    <div class="flex gap-3 mb-4 w-full border rounded p-1 bg-gray-50">
                        <x-atoms.form.button type="button" label="Xuất nội bộ"
                            class="{{ $stockoutType === 'internal'
                                ? 'flex-1 transition-all duration-300 transform scale-105 origin-center bg-green-100 text-green-800 rounded shadow-md'
                                : 'flex-1 transition-all duration-300 transform scale-95 origin-center opacity-50 hover:scale-100 hover:opacity-100' }}"
                            wire:click="setStockoutType('internal')" />

                        <x-atoms.form.button type="button" label="Bán hàng"
                            class="{{ $stockoutType === 'customer'
                                ? 'flex-1 transition-all duration-300 transform scale-105 origin-center bg-green-100 text-green-800 rounded shadow-md'
                                : 'flex-1 transition-all duration-300 transform scale-95 origin-center opacity-50 hover:scale-100 hover:opacity-100' }}"
                            wire:click="setStockoutType('customer')" />

                        <x-atoms.form.button type="button" label="Hoàn/Sửa/Bảo Hành"
                            class="{{ $stockoutType === 'vendor'
                                ? 'flex-1 transition-all duration-300 transform scale-105 origin-center bg-green-100 text-green-800 rounded shadow-md'
                                : 'flex-1 transition-all duration-300 transform scale-95 origin-center opacity-50 hover:scale-100 hover:opacity-100' }}"
                            wire:click="setStockoutType('vendor')" />
                    </div>
                </div>

                {{-- Vendor --}}
                <div class="mb-3 {{ $stockoutType !== 'vendor' ? 'hidden' : '' }}">
                    <x-atoms.form.select livewire-id="action_id" item-id="id" item-name="note" form-id="action_id"
                        label="Thao tác" :collection="$actionStockoutVendor" class-input="border rounded" defer="true"
                        name="action_id" />
                </div>
                <div class="mb-3 {{ $stockoutType !== 'vendor' ? 'hidden' : '' }}">
                    <x-atoms.form.select livewire-id="vendor_id" form-id="vendor_id" label="Nhà cung cấp"
                        :collection="$vendorOptions" class-input="border rounded" defer="true" name="vendor_id" />
                </div>

                {{-- Customer --}}
                <div class="mb-3 {{ $stockoutType !== 'customer' ? 'hidden' : '' }}">
                    <x-atoms.form.select livewire-id="action_id" item-id="id" item-name="note" form-id="action_id"
                        label="Thao tác" :collection="$actionStockoutCustomer" class-input="border rounded" defer="true"
                        name="action_id" />
                </div>
                <div class="mb-3 {{ $stockoutType !== 'customer' ? 'hidden' : '' }}">
                    <x-atoms.form.select livewire-id="customer_id" form-id="customer_id" label="Khách hàng"
                        :collection="$customerOptions" class-input="border rounded" defer="true" name="customer_id" />
                </div>

                {{-- Internal --}}
                <div class="mb-3 {{ $stockoutType !== 'internal' ? 'hidden' : '' }}">
                    <x-atoms.form.select livewire-id="action_id" item-id="id" item-name="note" form-id="action_id"
                        label="Thao tác" :collection="$actionStockoutInternal" class-input="border rounded" defer="true"
                        name="action_id" />
                </div>
                <div class="mb-3 {{ $stockoutType !== 'internal' ? 'hidden' : '' }}">
                    <x-atoms.form.select livewire-id="location_id" form-id="location_id" label="Vị trí"
                        :collection="$locationOptions" class-input="border rounded" defer="true" name="location_id" />
                </div>
            </div>
            <hr class="my-4" />
            <div class="flex justify-between gap-3">
                <x-atoms.form.button type="submit" label="Xác nhận xuất kho" color="primary"
                    class="flex-1 py-2 text-sm font-medium" />
                <x-atoms.form.button type="button" label="Hủy bỏ" color="secondary" onclick="closePopup()"
                    class="flex-1 py-2 text-sm font-medium" />
            </div>
        </form>
    @else
        <div class="h-[78vh] flex items-center justify-center text-center">
            <div class="bg-blue-100 text-blue-800 p-6 rounded-lg shadow-md">
                <i class="fas fa-qrcode fa-3x mb-4"></i>
                <h2 class="text-2xl font-semibold mb-2">Chưa chọn linh kiện</h2>
                <p class="text-lg">Vui lòng quét mã QR hoặc tìm kiếm để chọn một linh kiện cần xuất kho.</p>
            </div>
        </div>
    @endif
</div>
