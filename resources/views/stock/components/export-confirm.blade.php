@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg rounded-4">
                    <div class="card-header bg-info text-white text-center rounded-top-4">
                        <h4 class="mb-0"><i class="fas fa-truck-loading mr-2"></i> Xác nhận xuất kho linh kiện</h4>
                    </div>

                    <div class="card-body bg-light-subtle">
                        {{-- Flash messages --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        {{-- Thông tin linh kiện --}}
                        <div class="row g-4 align-items-center justify-content-center mb-4">
                            <div class="col-md-5 text-center">
                                <img src="{{ $link_qr }}" alt="QR Code"
                                    class="img-thumbnail shadow-sm border border-2 rounded-3"
                                    style="max-width: 100%; height: auto;">
                            </div>

                            <div class="col-md-7">
                                <div class="border rounded-3 p-3 bg-white shadow-sm">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Serial:</strong> {{ $component->serial_number }}
                                        </li>
                                        <li class="list-group-item"><strong>Phân loại:</strong> {{ $component->category }}
                                        </li>
                                        <li class="list-group-item"><strong>Tình trạng:</strong> {{ $component->condition }}
                                        </li>
                                        <li class="list-group-item"><strong>Vị trí:</strong> {{ $component->location }}</li>
                                        <li class="list-group-item"><strong>Trạng thái:</strong> {{ $component->status }}
                                        </li>
                                        <li class="list-group-item"><strong>Mô tả:</strong> {{ $component->description }}
                                        </li>

                                        <li class="list-group-item"><strong>Ngày nhập:</strong>
                                            {{ $component->created_at ? $component->created_at->format('d/m/Y H:i') : '-' }}
                                        </li>
                                        <li class="list-group-item"><strong>Cập nhật gần nhất:</strong>
                                            {{ $component->updated_at ? $component->updated_at->format('d/m/Y H:i') : '-' }}
                                        </li>
                                        <li class="list-group-item"><strong>Thu hồi trước đây:</strong>
                                            {{ $component->recalled_at ? $component->recalled_at : '-' }}
                                        </li>
                                        <li class="list-group-item"><strong>Xuất kho trước đây:</strong>
                                            {{ $component->exported_at ? $component->exported_at : '-' }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Form xuất kho --}}
                        <form action="{{ route('components.exportpost', $component->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="reason" class="form-label"><strong>Lý do xuất kho <span
                                            class="text-danger">*</span></strong></label>
                                <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="4"
                                    placeholder="Nhập lý do xuất kho..." required>{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check-circle mr-2"></i> Xác nhận xuất kho
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="history.back()">
                                    <i class="fas fa-times-circle mr-2"></i> Hủy bỏ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom style --}}
    <style>
        .bg-light-subtle {
            background-color: #f9fafc;
        }

        .btn:hover {
            transform: scale(1.02);
            transition: all 0.2s ease-in-out;
        }

        .list-group-item {
            padding-top: 8px;
            padding-bottom: 8px;
        }
    </style>
@endsection
