@props([
    'class' => '',
    'record' => null,
])
@php
    $actionId = data_get($record, 'ThaoTacId');
    $target = data_get($record, 'ThaoTacTarget');
    $actionNote = data_get($record, 'ThaoTac');
    $diaChi = data_get($record, 'DiaChi');
    $nhaCungCap = data_get($record, 'NhaCungCap');
    $khachHang = data_get($record, 'KhachHang');
    $nguoiThucHien = data_get($record, 'NguoiThucHien');
    if ($diaChi) {
        $where = $diaChi;
    } elseif ($nhaCungCap) {
        $where = $nhaCungCap;
    } elseif ($khachHang) {
        $where = $khachHang;
    } else {
        $where = $nguoiThucHien;
    }

    $config = match ($target) {
        'component' => [
            'label' => 'Nhập kho',
            'color' => 'bg-cyan-50 text-cyan-800',
        ],
        'componentStockoutCustomer' => [
            'label' => 'Bán hàng',
            'color' => 'bg-blue-100 text-blue-800',
        ],
        'componentStockoutInternal' => [
            'label' => 'Xuất nội bộ',
            'color' => 'bg-green-100 text-green-800',
        ],
        'componentStockoutVendor' => [
            'label' => 'Hoàn/Sửa/Bảo Hành',
            'color' => 'bg-purple-100 text-purple-800',
        ],
        'componentStockreturn' => [
            'label' => 'Trả hàng',
            'color' => 'bg-red-100 text-red-800',
        ],
        default => [
            'label' => 'Không xác định',
            'color' => 'bg-gray-100 text-gray-800',
        ],
    };

    $label = $config['label'];
    $color = $config['color'];

    $title = "{$label}: {$actionNote}";
@endphp

<td class="px-6 py-3 text-sm text-gray-900 whitespace-nowrap border-gray-200 {{ $class }}"
    title="{{ $title }}">
    <span
        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['color'] }} whitespace-nowrap">
        {{ $config['label'] }}: {{ $actionNote }}
    </span>
    <span
        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['color'] }} whitespace-nowrap">
        {{ $where }} 
    </span>
</td>
