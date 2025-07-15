@extends('layouts.content')
@section('prop')
    @php
        $title = 'Thêm mới linh kiện';
        $icon = 'fas fa-plus';
    @endphp
@endsection

@section('content')
    <div class="row pt-2 w-full">
        {{-- CỘT PHẢI: QR CODE + THÔNG TIN LINH KIỆN --}}
        <div class="p-0 w-full md:w-1/2 p-4 h-full flex flex-col gap-4">
            {{-- QR Code (chiếm 50%) --}}
            <div
                class="flex-1 flex-col basis-1/2 border-2 border-dashed border-gray-300 rounded-2xl flex items-center justify-center transition-opacity duration-300 p-5 {{ $createSuccess ? '' : 'opacity-60' }}">
                <img src="{{ $createSuccess['qrcode'] ?? asset('img/qrcode-default.jpg') }}" alt="QR Code"
                    class="max-w-[70%] max-h-[70%] object-contain">
                @unless ($createSuccess)
                    <p class="bottom-4 text-sm text-gray-500 mb-12">QR code/Barcode sẽ hiển thị tại đây</p>
                @endunless
            </div>

            @if ($createSuccess)
                <div class="text-md flex flex-col items-center border-2 border-dashed border-gray-300 mt-1 p-1 rounded">
                    <p class="text-back-600 mt-2">Serial number</p>
                    <img src="{{ $createSuccess['barcode'] }}" alt="Barcode" class="max-w-[64%]">
                </div>
            @endif

            {{-- Thông tin (chiếm 50%) --}}
            <div class="flex-1 basis-1/2 overflow-y-auto">

                @if ($createSuccess)
                    {{-- Alert --}}
                    <div class="flex items-center bg-green-100 text-green-800 text-sm font-medium p-3 mb-3 rounded">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Thêm mới thành công!</span>
                    </div>

                    {{-- Thông tin chi tiết --}}
                    <div class="border rounded-xl p-4 bg-white max-h-60 overflow-y-auto mb-6">
                        <h5 class="text-green-600 font-semibold mb-3 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>Thông tin linh kiện
                        </h5>
                        <ul class="text-sm divide-y divide-gray-200">
                            @foreach ($createSuccess as $key => $value)
                                @continue($key === 'qrcode' || $key === 'serial_number' || $key === 'barcode')
                                <li class="py-2">
                                    <span class="font-semibold capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                                    <span class="ml-1">{{ $value ?? '-' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="text-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-info-circle mr-1"></i>
                        Thông tin sẽ hiển thị sau khi thêm mới
                    </p>
                @endif

            </div>
        </div>

        {{-- FORM BÊN TRÁI --}}
        <div class="col-md-6 border-end">

            {{-- Hiển thị lỗi validation --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form wire:submit.prevent="createSubmit">
                {{-- SERIAL NUMBER tách riêng để thêm autofocus --}}
                <div class="mb-1">
                    <label for="serial-number-generate" class="form-label">Serial number<span class="text-warning">
                            *</span></label>
                    <div class="input-group border-main">
                        <span class="input-group-text border-0""><i class="fas fa-barcode"></i></span>
                        <input wire:model.defer="serial_number" type="text" name="serial_number"
                            id="serial-number-generate" class="border-0 form-create form-control input-hover"
                            placeholder="Nhập số serial chính xác (ví dụ: SN123456789)" autofocus required>
                    </div>
                    <p class="mt-2 fw-bold" id="code-output-serial_number"></p>
                </div>

                {{-- CÁC FIELD CÒN LẠI --}}
                @php
                    $categoryOptions = [];
                    $conditionOptions = [];
                    $locationOptions = [];
                    $vendorOptions = [];
                    $manufacturerOptions = [];

                    foreach ($categories as $category) {
                        $categoryOptions[$category->id] = $category->name;
                    }
                    foreach ($conditions as $condition) {
                        $conditionOptions[$condition->id] = $condition->name;
                    }
                    foreach ($locations as $location) {
                        $locationOptions[$location->id] = $location->name;
                    }
                    foreach ($vendors as $vendor) {
                        $vendorOptions[$vendor->id] = $vendor->name;
                    }
                    foreach ($manufacturers as $manufacturer) {
                        $manufacturerOptions[$manufacturer->id] = $manufacturer->name;
                    }

                    $fields = [
                        [
                            'livewire' => 'condition_id',
                            'name' => 'condition',
                            'label' => 'Tình trạng',
                            'icon' => 'fas fa-microchip',
                            'type' => 'select',
                            'options' => $conditionOptions,
                        ],
                        [
                            'livewire' => 'location_id',
                            'name' => 'location',
                            'label' => 'Vị trí',
                            'icon' => 'fas fa-map-marker-alt',
                            'type' => 'select',
                            'options' => $locationOptions,
                        ],
                    ];
                    $vendorFields = [
                        'livewire' => 'vendor_id',
                        'name' => 'vendor',
                        'label' => 'Nhà cung cấp',
                        'icon' => 'fas fa-store',
                        'type' => 'select',
                        'options' => $vendorOptions,
                    ];
                    $manufacturerFields = [
                        'livewire' => 'manufacturer_id',
                        'name' => 'manufacturer',
                        'label' => 'Hãng sản xuất',
                        'icon' => 'fas fa-industry',
                        'type' => 'select',
                        'options' => $manufacturerOptions,
                    ];
                    $categoryFields = [
                        'livewire' => 'category_id',
                        'name' => 'category',
                        'label' => 'Phân loại',
                        'icon' => 'fas fa-cogs',
                        'type' => 'select',
                        'options' => $categoryOptions,
                    ];

                @endphp

                <div class="d-flex gap-3 flex-wrap">

                    <div class="flex-grow-1">
                        <label for="name" class="form-label">Tên linh kiện<span class="text-warning">
                                *</span></label>
                        <div class="input-group border-main">
                            <span class="input-group-text border-0" icon-scale border-0"><i class="fas fa-tags"></i></span>
                            <input wire:model.defer="name" type="text" class="form-control input-hover border-0" required
                                placeholder="Nhập tên linh kiện">
                        </div>
                    </div>


                    {{-- Ngày nhập kho --}}
                    <div class="flex-grow-1" style="min-width: 200px;">
                        <label for="stockin_at" class="form-label">Ngày nhập kho<span class="text-warning">
                                *</span></label>
                        <div class="input-group border-main">
                            <span class="input-group-text border-0" icon-scale border-0"><i
                                    class="fas fa-calendar-alt"></i></span>
                            <input wire:model.defer="stockin_at" type="date" class="form-control input-hover border-0"
                                required>
                        </div>
                    </div>
                </div>

                {{-- Bảo hành --}}
                <div class="p-3 mt-3 rounded" style="border: 1px solid #28a745">
                    <div class="text-success p-1 flex rounded gap-3 flex-wrap items-center">
                        <input type="checkbox"
                            onclick="event.preventDefault(); Livewire.emit('toggleWarranty', {{ $toggleWarranty ? 'null' : 'true' }})"
                            {{ $warranty_start ? 'checked' : '' }}>

                        <i class="fas fa-shield-alt nav-icon"></i>
                        <p class="mb-0">Linh kiện có bảo hành</p>
                    </div>

                    @if ($toggleWarranty)
                        <div class="flex gap-3 flex-wrap mt-3">
                            <div class="flex-grow-1 min-w-[200px]">
                                <label for="warranty_start" class="form-label">Ngày bắt đầu bảo hành</label>
                                <div class="input-group border rounded">
                                    <span class="input-group-text border-0"><i class="fas fa-shield-alt"></i></span>
                                    <input wire:model.defer="warranty_start" type="date" id="warranty_start"
                                        class="form-control input-hover border-0" required>
                                </div>
                            </div>

                            <div class="flex-grow-1 min-w-[200px]">
                                <label for="warranty_end" class="form-label">Ngày kết thúc bảo hành</label>
                                <div class="input-group border rounded">
                                    <span class="input-group-text border-0"><i class="fas fa-calendar"></i></span>
                                    <input wire:model.defer="warranty_end" type="date" id="warranty_end"
                                        class="form-control input-hover border-0" required>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Phân loại --}}
                <div class="mb-1 mt-1">
                    <label for="{{ $categoryFields['name'] }}" class="form-label">{{ $categoryFields['label'] }}
                    </label>
                    <div class="input-group border rounded">
                        <span class="input-group-text border-0" border-0"><i
                                class="{{ $categoryFields['icon'] }}"></i></span>
                        <select wire:model.defer="{{ $categoryFields['livewire'] }}" id="{{ $categoryFields['name'] }}"
                            class="form-control input-hover border-0" required>
                            <option>-- Chọn {{ strtolower($categoryFields['label']) }}
                                --
                            </option>
                            @foreach ($categoryFields['options'] as $key => $option)
                                <option value="{{ $key }}"
                                    {{ old($categoryFields['name']) == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select><i class="ml-2"></i><i class="ml-2"></i>
                    </div>
                </div>

                @foreach ($fields as $keyId => $field)
                    <div class="mb-1 mt-1">
                        <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}
                        </label>
                        <div class="input-group border rounded">
                            <span class="input-group-text border-0""><i class="{{ $field['icon'] }}"></i></span>
                            <select wire:model.defer="{{ $field['livewire'] }}" id="{{ $field['name'] }}"
                                class="form-control input-hover border-0">
                                <option>-- Chọn {{ strtolower($field['label']) }} --
                                </option>
                                @foreach ($field['options'] as $key => $option)
                                    <option value="{{ $key }}"
                                        {{ old($field['name']) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select><i class="ml-2"></i>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex gap-3 flex-wrap">
                    {{-- Hãng sản xuất --}}
                    <div class="flex-grow-1" style="min-width: 200px;">
                        <label for="{{ $manufacturerFields['name'] }}"
                            class="form-label">{{ $manufacturerFields['label'] }}</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text border-0""><i
                                    class="{{ $manufacturerFields['icon'] }}"></i></span>
                            <select wire:model.defer="{{ $manufacturerFields['livewire'] }}"
                                id="{{ $manufacturerFields['name'] }}" class="form-control input-hover border-0">
                                <option>-- Chọn {{ strtolower($manufacturerFields['label']) }}
                                    --</option>
                                @foreach ($manufacturerFields['options'] as $key => $option)
                                    <option value="{{ $key }}"
                                        {{ $manufacturerFields['name'] == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select><i class="ml-2"></i>
                        </div>
                    </div>

                    {{-- Nhà cung cấp --}}
                    <div class="flex-grow-1" style="min-width: 200px;">
                        <label for="{{ $vendorFields['name'] }}" class="form-label">{{ $vendorFields['label'] }}</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text border-0""><i class="{{ $vendorFields['icon'] }}"></i></span>
                            <select wire:model.defer="{{ $vendorFields['livewire'] }}" id="{{ $vendorFields['name'] }}"
                                class="form-control input-hover border-0">
                                <option value="">-- Chọn {{ strtolower($vendorFields['label']) }}
                                    --</option>
                                @foreach ($vendorFields['options'] as $key => $option)
                                    <option value="{{ $key }}"
                                        {{ $vendorFields['name'] == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select><i class="ml-2"></i>
                        </div>
                    </div>
                </div>

                {{-- MÔ TẢ --}}
                <div class="mb-1 mt-1">
                    <label for="note" class="form-label">Mô tả</label>
                    <textarea wire:model.defer="note" name="note" rows="3" class="form-control input-hover mb-4"
                        placeholder="Ghi chú về linh kiện"></textarea>
                </div>

                {{-- NÚT --}}
                <div class="gapflex d-flex gap-2">
                    <button type="submit" class="flex-fill btn btn-success btn-hover-warning">
                        <i class="fas fa-plus me-2"></i> Thêm mới
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
