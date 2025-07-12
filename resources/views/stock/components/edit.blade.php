@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg rounded-4">
                    <div class="card-header bg-main text-white text-center rounded-top-4">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i> Cập nhật thông tin linh kiện</h4>
                    </div>

                    <div class="card-body bg-light-subtle">
                        {{-- Hiển thị lỗi nếu có --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('components.update', $component->id) }}">
                            @csrf
                            @method('PUT')

                            @php
                                $fields = [
                                    [
                                        'name' => 'serial_number',
                                        'label' => 'Serial number',
                                        'icon' => 'fas fa-barcode',
                                        'type' => 'text',
                                        'placeholder' => 'Nhập số serial chính xác (ví dụ: SN123456789)',
                                    ],
                                    [
                                        'name' => 'category',
                                        'label' => 'Phân loại',
                                        'icon' => 'fas fa-cogs',
                                        'type' => 'select',
                                        'options' => [
                                            'RAM',
                                            'Chip',
                                            'Quạt',
                                            'Tản',
                                            'Ổ cứng',
                                            'Nguồn',
                                            'Main',
                                            'VGA',
                                            'Case',
                                            'Khác',
                                        ],
                                    ],
                                    [
                                        'name' => 'condition',
                                        'label' => 'Tình trạng',
                                        'icon' => 'fas fa-microchip',
                                        'type' => 'select',
                                        'options' => [
                                            'Mới 100%',
                                            'Like new',
                                            'Sử dụng ổn định',
                                            'Tình trạng bất ổn',
                                            'Đang chờ sửa chữa',
                                            'Đã gửi đi sửa chữa',
                                            'Hư hỏng',
                                        ],
                                    ],
                                    [
                                        'name' => 'location',
                                        'label' => 'Vị trí',
                                        'icon' => 'fas fa-map-marker-alt',
                                        'type' => 'select',
                                        'options' => ['Kho 1', 'Kho 2'],
                                    ],
                                ];
                            @endphp

                            @foreach ($fields as $field)
                                <div class="mb-3">
                                    <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="{{ $field['icon'] }}"></i></span>

                                        @if ($field['type'] === 'select')
                                            <select name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                                class="form-control input-hover" required>
                                                <option value="">-- Chọn {{ strtolower($field['label']) }} --</option>
                                                @foreach ($field['options'] as $option)
                                                    <option value="{{ $option }}"
                                                        {{ old($field['name'], $component->{$field['name']}) == $option ? 'selected' : '' }}>
                                                        {{ $option }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                                class="form-control input-hover"
                                                value="{{ old($field['name'], $component->{$field['name']}) }}"
                                                placeholder="{{ $field['placeholder'] ?? '' }}" required>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea name="description" id="description" rows="3" class="form-control input-hover"
                                    placeholder="Mô tả chi tiết...">{{ old('description', $component->description) }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn bg-main text-white btn-hover">
                                    <i class="fas fa-save me-2"></i> Lưu thay đổi
                                </button>
                                <a href="{{ route('components.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Style --}}
    <style>
        .bg-light-subtle {
            background-color: #f9fafc;
        }

        .input-hover:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.4);
        }

        .btn-hover:hover {
            background-color: #0b5ed7;
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .input-group-text {
            background-color: #e9ecef;
        }

        .bg-main {
            background-color: #ffc107 !important;
        }
    </style>
@endsection
