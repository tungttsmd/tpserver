@props([
    'createSuccess' => null,
    'categories' => collect(),
    'conditions' => collect(),
    'locations' => collect(),
    'vendors' => collect(),
    'manufacturers' => collect(),
    'toggleWarranty' => false,
])

@php
    $categoryOptions = $categories->pluck('name', 'id')->toArray();
    $conditionOptions = $conditions->pluck('name', 'id')->toArray();
    $locationOptions = $locations->pluck('name', 'id')->toArray();
    $vendorOptions = $vendors->pluck('name', 'id')->toArray();
    $manufacturerOptions = $manufacturers->pluck('name', 'id')->toArray();

    $fields = [
        [
            'livewire' => 'condition_id',
            'name' => 'condition',
            'label' => 'Tình trạng',
            'icon' => 'fas fa-microchip',
            'options' => $conditionOptions,
        ],
        [
            'livewire' => 'location_id',
            'name' => 'location',
            'label' => 'Vị trí',
            'icon' => 'fas fa-map-marker-alt',
            'options' => $locationOptions,
        ],
    ];

    $categoryField = [
        'livewire' => 'category_id',
        'name' => 'category',
        'label' => 'Phân loại',
        'icon' => 'fas fa-cogs',
        'options' => $categoryOptions,
    ];
    $vendorField = [
        'livewire' => 'vendor_id',
        'name' => 'vendor',
        'label' => 'Nhà cung cấp',
        'icon' => 'fas fa-store',
        'options' => $vendorOptions,
    ];
    $manufacturerField = [
        'livewire' => 'manufacturer_id',
        'name' => 'manufacturer',
        'label' => 'Hãng sản xuất',
        'icon' => 'fas fa-industry',
        'options' => $manufacturerOptions,
    ];
@endphp

<div class="flex flex-col md:flex-row gap-6 p-6 w-full">

    {{-- CỘT PHẢI: QR CODE + THÔNG TIN --}}
    <div class="w-full md:w-1/2 flex flex-col gap-12 p-4">

        {{-- QR Code --}}
        <div
            class="flex-1 flex flex-column gap-6 items-center justify-center border-2 border-dashed border-gray-300 rounded-2xl p-3 transition-opacity duration-300 {{ $createSuccess ? 'opacity-100' : 'opacity-60' }}">
            <img src="{{ $createSuccess['qrcode'] ?? asset('img/qrcode-default.jpg') }}" alt="QR Code"
                class="mr-12 max-w-[256px] max-h-[256px] object-contain m-0" />
            @unless ($createSuccess)
                <p class="text-sm text-gray-500 mr-16">QR code &amp; Barcode sẽ hiển thị tại đây</p>
            @endunless
            {{-- @if ($createSuccess)
                <div class="flex flex-col items-center mr-8 text-gray-700 font-semibold">
                    <p>Serial number</p>
                    <img src="{{ $createSuccess['barcode'] }}" alt="Barcode" />
                </div>
            @endif --}}
        </div>

        {{-- Thông tin --}}
        <div class="flex-1 overflow-y-auto max-h-60">
            @if ($createSuccess)
                <div class="bg-green-100 text-green-800 text-sm font-medium p-3 mb-3 rounded flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Thêm mới thành công!
                </div>
                <div class="border rounded-xl p-4 bg-white overflow-y-auto max-h-60 mb-6">
                    <h5 class="text-green-600 font-semibold mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>Thông tin linh kiện
                    </h5>
                    <ul class="text-sm divide-y divide-gray-200">
                        @foreach ($createSuccess as $key => $value)
                            @continue(in_array($key, ['qrcode', 'barcode']))
                            <li class="py-2">
                                <span class="font-semibold capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                                <span class="ml-1">{{ $value ?? '-' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-center text-sm text-gray-500 mb-4">
                    <i class="fas fa-info-circle mr-1"></i> Thông tin sẽ hiển thị sau khi thêm mới
                </p>
            @endif
        </div>
    </div>

    {{-- FORM BÊN TRÁI --}}
    <div class="w-full md:w-1/2 border-r border-gray-300 pr-6">

        {{-- Lỗi validation --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-3">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form wire:submit.prevent="createSubmit" class="space-y-6">

            {{-- Serial number --}}
            <div>
                <label for="serial-number-generate" class="block text-sm font-medium text-gray-700">Serial number <span
                        class="text-warning">*</span></label>
                <div
                    class="mt-1 relative rounded-md shadow-sm flex items-center border border-gray-300 focus-within:border-primary-600 focus-within:ring-1 focus-within:ring-primary-600">
                    <span class="pl-3 pr-2 text-gray-400 pointer-events-none"><i class="fas fa-barcode"></i></span>
                    <input wire:model.defer="serial_number" type="text" id="serial-number-generate"
                        class="block w-full border-0 py-2 pl-1 pr-3 text-gray-900 placeholder-gray-400 focus:ring-0 sm:text-sm"
                        placeholder="Nhập số serial chính xác (ví dụ: SN123456789)" autofocus required />
                </div>
            </div>

            {{-- Tên linh kiện + Ngày nhập kho --}}
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[12rem]">
                    <label for="name" class="block text-sm font-medium text-gray-700">Tên linh kiện <span
                            class="text-warning">*</span></label>
                    <div
                        class="mt-1 relative rounded-md shadow-sm flex items-center border border-gray-300 focus-within:border-primary-600 focus-within:ring-1 focus-within:ring-primary-600">
                        <span class="pl-3 pr-2 text-gray-400 pointer-events-none"><i class="fas fa-tags"></i></span>
                        <input wire:model.defer="name" type="text" id="name"
                            class="block w-full border-0 py-2 pl-1 pr-3 text-gray-900 placeholder-gray-400 focus:ring-0 sm:text-sm h-[40px]"
                            placeholder="Nhập tên linh kiện" required />
                    </div>
                </div>

                <div class="flex-1 min-w-[12rem]">
                    <label for="stockin_at" class="block text-sm font-medium text-gray-700">Ngày nhập kho <span
                            class="text-warning">*</span></label>
                    <div
                        class="mt-1 relative rounded-md shadow-sm flex items-center border border-gray-300 focus-within:border-primary-600 focus-within:ring-1 focus-within:ring-primary-600">
                        <span class="pl-3 pr-2 text-gray-400 pointer-events-none"><i
                                class="fas fa-calendar-alt"></i></span>
                        <input wire:model.defer="stockin_at" type="date" id="stockin_at"
                            class="block w-full border-0 py-2 pl-1 pr-3 text-gray-900 placeholder-gray-400 focus:ring-0 sm:text-sm h-[40px]"
                            required />
                    </div>
                </div>
            </div>

            {{-- Bảo hành --}}
            <div class="pt-2 pb-2 pl-3 pr-3 mt-4 rounded border border-green-600 bg-green-50">
                <label class="cursor-pointer inline-flex items-center space-x-2 text-green-800 select-none mb-0 group">
                    <input type="checkbox" class="cursor-pointer form-checkbox h-4 w-4 text-green-600"
                        onclick="event.preventDefault(); Livewire.emit('toggleWarranty', {{ $toggleWarranty ? 'null' : 'true' }})"
                        {{ $warranty_start ? 'checked' : '' }} />
                    <i class="fas fa-shield-alt"></i>
                    <span class="text-sm">Linh kiện có bảo hành</span>
                </label>

                @if ($toggleWarranty)
                    <div class="mt-3 flex flex-wrap gap-4 pb-1">
                        <div class="flex-1 min-w-[12rem]">
                            <label for="warranty_start" class="block text-sm font-medium text-green-800">Ngày bắt đầu
                                bảo hành</label>
                            <div
                                class="mt-1 relative rounded-md shadow-sm flex items-center border border-green-600 focus-within:border-green-700 focus-within:ring-1 focus-within:ring-green-700">
                                <span class="pl-3 pr-2 text-green-600 pointer-events-none"><i
                                        class="fas fa-shield-alt"></i></span>
                                <input wire:model.defer="warranty_start" type="date" id="warranty_start"
                                    class="block w-full border-0 py-2 pl-1 pr-3 text-green-900 placeholder-green-400 focus:ring-0 sm:text-sm"
                                    required />
                            </div>
                        </div>
                        <div class="flex-1 min-w-[12rem]">
                            <label for="warranty_end" class="block text-sm font-medium text-green-800">Ngày kết thúc bảo
                                hành</label>
                            <div
                                class="mt-1 relative rounded-md shadow-sm flex items-center border border-green-600 focus-within:border-green-700 focus-within:ring-1 focus-within:ring-green-700">
                                <span class="pl-3 pr-2 text-green-600 pointer-events-none"><i
                                        class="fas fa-calendar"></i></span>
                                <input wire:model.defer="warranty_end" type="date" id="warranty_end"
                                    class="block w-full border-0 py-2 pl-1 pr-3 text-green-900 placeholder-green-400 focus:ring-0 sm:text-sm"
                                    required />
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Phân loại --}}
            <div>
                <label for="{{ $categoryField['name'] }}"
                    class="block text-sm font-medium text-gray-700">{{ $categoryField['label'] }}</label>
                <div
                    class="mt-1 relative rounded-md shadow-sm flex items-center border border-gray-300 focus-within:border-primary-600 focus-within:ring-1 focus-within:ring-primary-600">
                    <span class="pl-3 pr-2 text-gray-400 pointer-events-none"><i
                            class="{{ $categoryField['icon'] }}"></i></span>
                    <select wire:model.defer="{{ $categoryField['livewire'] }}" id="{{ $categoryField['name'] }}"
                        class="block w-full border-0 py-2 pl-1 pr-3 text-gray-900 focus:ring-0 sm:text-sm">
                        <option value="">-- Chọn {{ strtolower($categoryField['label']) }} --</option>
                        @foreach ($categoryField['options'] as $key => $option)
                            <option value="{{ $key }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Các field condition, location --}}
            @foreach ($fields as $field)
                <div>
                    <label for="{{ $field['name'] }}"
                        class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                    <div
                        class="mt-1 relative rounded-md shadow-sm flex items-center border border-gray-300 focus-within:border-primary-600 focus-within:ring-1 focus-within:ring-primary-600">
                        <span class="pl-3 pr-2 text-gray-400 pointer-events-none"><i
                                class="{{ $field['icon'] }}"></i></span>
                        <select wire:model.defer="{{ $field['livewire'] }}" id="{{ $field['name'] }}"
                            class="block w-full border-0 py-2 pl-1 pr-3 text-gray-900 focus:ring-0 sm:text-sm">
                            <option value="">-- Chọn {{ strtolower($field['label']) }} --</option>
                            @foreach ($field['options'] as $key => $option)
                                <option value="{{ $key }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach

            {{-- Hãng sản xuất & Nhà cung cấp --}}
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[12rem]">
                    <label for="{{ $manufacturerField['name'] }}"
                        class="block text-sm font-medium text-gray-700">{{ $manufacturerField['label'] }}</label>
                    <div
                        class="mt-1 relative rounded-md shadow-sm flex items-center border border-gray-300 focus-within:border-primary-600 focus-within:ring-1 focus-within:ring-primary-600">
                        <span class="pl-3 pr-2 text-gray-400 pointer-events-none"><i
                                class="{{ $manufacturerField['icon'] }}"></i></span>
                        <select wire:model.defer="{{ $manufacturerField['livewire'] }}"
                            id="{{ $manufacturerField['name'] }}"
                            class="block w-full border-0 py-2 pl-1 pr-3 text-gray-900 focus:ring-0 sm:text-sm">
                            <option value="">-- Chọn {{ strtolower($manufacturerField['label']) }} --</option>
                            @foreach ($manufacturerField['options'] as $key => $option)
                                <option value="{{ $key }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex-1 min-w-[12rem]">
                    <label for="{{ $vendorField['name'] }}"
                        class="block text-sm font-medium text-gray-700">{{ $vendorField['label'] }}</label>
                    <div
                        class="mt-1 relative rounded-md shadow-sm flex items-center border border-gray-300 focus-within:border-primary-600 focus-within:ring-1 focus-within:ring-primary-600">
                        <span class="pl-3 pr-2 text-gray-400 pointer-events-none"><i
                                class="{{ $vendorField['icon'] }}"></i></span>
                        <select wire:model.defer="{{ $vendorField['livewire'] }}" id="{{ $vendorField['name'] }}"
                            class="block w-full border-0 py-2 pl-1 pr-3 text-gray-900 focus:ring-0 sm:text-sm">
                            <option value="">-- Chọn {{ strtolower($vendorField['label']) }} --</option>
                            @foreach ($vendorField['options'] as $key => $option)
                                <option value="{{ $key }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div>
                <label for="note" class="block text-sm font-medium text-gray-700">Mô tả</label>
                <textarea wire:model.defer="note" id="note" rows="3"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm py-2 pl-1 pr-3 text-gray-900 placeholder-gray-400 focus:border-primary-600 focus:ring focus:ring-primary-200 focus:ring-opacity-50 sm:text-sm"
                    placeholder="Ghi chú về linh kiện"></textarea>
            </div>

            {{-- Nút submit --}}
            <div>
                <button type="submit"
                    class="inline-flex justify-center items-center gap-2 rounded-md bg-green-600 px-4 py-2 text-white text-sm font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class="fas fa-plus"></i> Thêm mới
                </button>
            </div>

        </form>
    </div>
</div>
