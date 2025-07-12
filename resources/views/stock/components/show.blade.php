@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg rounded-4">
                    <div class="card-header bg-info text-white text-center rounded-top-4">
                        <h4 class="mb-0"><i class="fas fa-info-circle mr-2"></i> Thông tin linh kiện</h4>
                    </div>

                    <div class="card-body bg-light-subtle">
                        <div class="row g-4 align-items-center justify-content-center">
                            {{-- QR Code --}}
                            <div class="col-md-5 text-center">
                                <img src="{{ $link_qr }}" alt="QR Code"
                                    class="img-thumbnail shadow-sm border border-2 rounded-3"
                                    style="max-width: 100%; height: auto;">
                            </div>

                            {{-- Thông tin chi tiết --}}
                            <div class="col-md-7">
                                <div class="border rounded-3 p-3 bg-white shadow-sm">
                                    <ul class="list-group list-group-flush">
                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show mt-3"
                                                role="alert">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                {{ session('success') }}
                                            </div>
                                        @elseif (session('info'))
                                            <div class="alert alert-warning alert-dismissible fade show mt-3"
                                                role="alert">
                                                <i class="fas fa-exclamation-circle mr-2"></i>
                                                {{ session('info') }}
                                            </div>
                                        @endif
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

                                        <li class="list-group-item"><strong>Ngày tạo:</strong>
                                            {{ $component->created_at ? $component->created_at->format('d/m/Y H:i') : '-' }}
                                        </li>
                                        <li class="list-group-item"><strong>Ngày cập nhật:</strong>
                                            {{ $component->updated_at ? $component->updated_at->format('d/m/Y H:i') : '-' }}
                                        </li>
                                        <li class="list-group-item"><strong>Ngày xuất kho:</strong>
                                            {{ $component->exported_at ? $component->exported_at : '-' }}
                                        </li>
                                        <li class="list-group-item"><strong>Ngày thu hồi:</strong>
                                            {{ $component->recalled_at ? $component->recalled_at : '-' }}
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>

                        {{-- Nút hành động --}}
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <a href="{{ route('components.edit', ['component' => $component->id]) }}"
                                    class="btn btn-warning me-2">
                                    <i class="fas fa-edit me-1"></i> Sửa
                                </a>

                                <form action="{{ route('components.destroy', $component->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Bạn có chắc muốn xoá linh kiện này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash-alt me-1"></i> Xoá
                                    </button>
                                </form>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="history.back()">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom style kế thừa từ layout --}}
    <style>
        .list-group-item {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .btn:hover {
            transform: scale(1.02);
            transition: all 0.2s ease-in-out;
        }

        .bg-light-subtle {
            background-color: #f9fafc;
        }

        .bg-main {
            background-color: #4b6cb7 !important;
            color: white !important;
        }
    </style>
@endsection
