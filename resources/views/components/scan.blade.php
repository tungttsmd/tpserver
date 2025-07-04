@extends('layouts.app')

@section('content')
    <div class="tpserver container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg rounded-4">
                    <div class="card-header bg-main text-white text-center rounded-top-4">
                        <h4 class="mb-0"><i class="fas fa-plus mr-2"></i> Scan code linh kiện</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @if (session('info'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('info') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- FORM BÊN TRÁI --}}
                            <div class="col-md-12 border-end">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('components.scanpost') }}">
                                    @csrf

                                    {{-- SERIAL NUMBER tách riêng để thêm autofocus --}}
                                    <div class="mb-3">
                                        <label for="serial_number" class="form-label">Serial number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            <input type="text" name="serial_number" id="serial_number"
                                                class="form-control input-hover" value="{{ old('serial_number') }}" required
                                                placeholder="Nhập số serial chính xác (ví dụ: SN123456789)" autofocus>
                                        </div>
                                    </div>


                                    {{-- NÚT --}}
                                    <div class="gapflex d-flex gap-2">
                                        <button type="submit" class="flex-fill btn bg-success btn-hover">
                                            <i class="fas fa-plus me-2"></i> Scan
                                        </button>
                                        <a type="button" class="flex-fill btn btn-secondary"
                                            href="{{ route('components.index') }}">
                                            <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
                                        </a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tpserver .gapflex {
            gap: 20px;
        }

        .qr-frame {
            position: relative;
            padding: 24px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            border: 2px solid transparent;
            max-width: 100%;
            max-height: 100%;
            overflow: hidden;
            /* Tạo viền tổng thể mờ để không bị thô */
            background-clip: padding-box;
        }

        /* Viền góc camera sắc nét */
        .qr-frame::before,
        .qr-frame::after {
            content: "";
            position: absolute;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            box-sizing: border-box;
            background: white;
            box-shadow: inset 0 6px 6px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .qr-frame::before {
            top: 6px;
            left: 6px;
            border-right: none;
            border-bottom: none;
        }

        .qr-frame::after {
            bottom: 6px;
            right: 6px;
            border-left: none;
            border-top: none;
        }

        .qr-frame img {
            border-radius: 12px;
            max-height: 220px;
            /* Giới hạn kích thước QR */
            max-width: 220px;
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .card-header h5 i,
        .card-header h4,
        .card-header i {
            vertical-align: middle;
        }

        .list-group-item {
            padding: 8px 0;
            white-space: normal !important;
            overflow-wrap: break-word;
            max-width: 100%;
            box-sizing: border-box;
        }

        .bg-light-subtle {
            background-color: #f9fafc;
        }

        .input-hover:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.4);
        }

        .input-hover:hover {
            border-color: #0d6efd;
        }

        .btn-hover:hover {
            background-color: #0b5ed7;
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .input-group-text {
            background-color: #e9ecef;
        }

        textarea.form-control {
            resize: vertical;
        }

        .bg-main {
            background-color: #4b6cb7 !important;
            color: white !important;
        }

        .detail-container {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
            box-sizing: border-box;
        }

        .opacity-50 {
            opacity: 0.5;
        }
    </style>
    @if (session('info'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection
