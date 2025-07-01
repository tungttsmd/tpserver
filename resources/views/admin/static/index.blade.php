@extends('layouts.app')

@section('content')
    <div class="container-fluid d-flex justify-content-center">
        <div class="p-5" style="width: 1140px">
            {{-- Thống kê tổng quan --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-primary">
                        <div class="card-body text-center">
                            <h6 class="card-title text-muted mb-1">Tổng số linh kiện</h6>
                            <h3 class="fw-bold text-primary">{{ $totalComponents }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-success">
                        <div class="card-body text-center">
                            <h6 class="card-title text-muted mb-1">Còn hàng</h6>
                            <h3 class="fw-bold text-success">{{ $inStock }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-danger">
                        <div class="card-body text-center">
                            <h6 class="card-title text-muted mb-1">Đã xuất</h6>
                            <h3 class="fw-bold text-danger">{{ $exported }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Biểu đồ --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title fw-semibold text-muted mb-3">
                                Tình trạng kho (biểu đồ)
                            </h6>
                            <canvas id="stockChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title fw-semibold text-muted mb-3">
                                Loại linh kiện (biểu đồ)
                            </h6>
                            <canvas id="categoryChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bộ lọc thống kê --}}
            <form method="GET" action="{{ route('static.index') }}" class="mb-4">
                <div class="row g-3">
                    {{-- Lọc theo loại linh kiện --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Phân loại</label>
                        <select name="category" class="form-select shadow-sm">
                            <option value="">Tất cả</option>
                            @foreach (['RAM', 'Chip', 'VGA', 'Main', 'Nguồn', 'Quạt', 'Khác'] as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Lọc theo thời gian cập nhật --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Từ ngày</label>
                        <input type="date" name="start_date" class="form-control shadow-sm"
                            value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Đến ngày</label>
                        <input type="date" name="end_date" class="form-control shadow-sm"
                            value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i> Lọc
                            </button>
                            <a href="{{ route('static.index') }}" class="btn btn-danger">
                                <i class="fas fa-undo me-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        const stockCtx = document.getElementById('stockChart').getContext('2d');
        new Chart(stockCtx, {
            type: 'doughnut',
            data: {
                labels: ['Còn hàng', 'Đã xuất'],
                datasets: [{
                    data: [{{ $inStock }}, {{ $exported }}],
                    backgroundColor: ['#28a745', '#dc3545']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($categoryStats->toArray())) !!},
                datasets: [{
                    label: 'Số lượng',
                    data: {!! json_encode(array_values($categoryStats->toArray())) !!},
                    backgroundColor: '#4b6cb7',
                    borderRadius: 6
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection
