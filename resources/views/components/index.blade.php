@extends('layouts.app')
@section('title',"Quản lý linh kiện")
@section('content')
    <div class="container ">

        {{-- Bộ lọc --}}
        <form method="GET" action="{{ route('components.index') }}" class="mb-4">
            <div class="row g-3 align-items-end" style="gap: 20px">
                <div class="mt-4 card-body card mb-0">
                    <div class="row align-items-center g-2">
                        {{-- Nút lọc --}}
                        <div class="col-md-4 d-flex flex-row gap" style="gap: 20px">
                            {{-- Nút reset --}}
                            <a href="{{ route('components.index') }}" class="btn btn-danger w-100">
                                <i class="fas fa-undo me-1"></i>
                            </a><button type="submit" class="btn w-100 text-white" style="background-color:#4b6cb7">
                                <i class="fas fa-search text-white"></i>
                            </button>
                        </div>
                        {{-- Ô tìm kiếm --}}
                        <div class="col-md-8 d-flex align-items-center">
                            <input type="text" name="search" class="form-control shadow-sm flex-grow-1"
                                value="{{ request('search') }}" placeholder="Tìm kiếm Serial hoặc Mô tả.">
                        </div>


                    </div>
                </div>
                <div class="mt-4 card-body d-flex flex-row card mb-0">
                    {{-- Phân loại --}}
                    <div class="col-md-3 d-flex flex-column">
                        <label class="form-label fw-semibold">Phân loại</label>
                        <select name="category" class="form-select shadow-sm">
                            <option value="">Tất cả</option>
                            @foreach (['RAM', 'Chip', 'VGA', 'Main', 'Nguồn', 'Quạt', 'Khác'] as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tình trạng --}}
                    <div class="col-md-3 d-flex flex-column">
                        <label class="form-label fw-semibold">Tình trạng</label>
                        <select name="condition" class="form-select shadow-sm">
                            <option value="">Tất cả</option>
                            @foreach (['Mới', 'Cũ', 'Hư'] as $cond)
                                <option value="{{ $cond }}" {{ request('condition') == $cond ? 'selected' : '' }}>
                                    {{ $cond }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Trạng thái --}}
                    <div class="col-md-3 d-flex flex-column">
                        <label class="form-label fw-semibold">Trạng thái</label>
                        <select name="status" class="form-select shadow-sm">
                            <option value="">Tất cả</option>
                            @foreach (['Sẵn kho', 'Đã xuất'] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Số dòng/trang --}}
                    <div class="col-md-3 d-flex flex-column">
                        <label class="form-label fw-semibold">Hiển thị</label>
                        <select name="perPage" class="form-select shadow-sm">
                            @foreach ([20, 50, 80, 100, 200] as $size)
                                <option value="{{ $size }}"
                                    {{ request('perPage', 20) == $size ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>



            </div>
        </form>

        {{-- Thông báo --}}
        @foreach (['success' => 'danger', 'error' => 'warning'] as $type => $alert)
            @if (session($type))
                <div class="alert alert-{{ $alert }} alert-dismissible fade show mt-3" role="alert">
                    <i class="fas {{ $type === 'success' ? 'fa-trash-alt' : 'fa-minus-circle' }} me-2"></i>
                    {{ session($type) }}
                </div>
            @endif
        @endforeach

        {{-- Bảng dữ liệu --}}
        @php
            $currentSort = request('sort', 'id');
            $currentDir = request('dir', 'desc');
            function sortHeader($label, $column)
            {
                $currentSort = request('sort', 'id');
                $currentDir = request('dir', 'desc');
                $newDir = $currentSort === $column && $currentDir === 'asc' ? 'desc' : 'asc';
                $icon =
                    $currentSort === $column ? 'fa-sort-amount-' . ($currentDir === 'asc' ? 'up' : 'down') : 'fa-sort';
                $url = route('components.index', array_merge(request()->all(), ['sort' => $column, 'dir' => $newDir]));
                return "<a href='{$url}' class='text-white text-decoration-none'>{$label} <i class='fas {$icon} ms-1'></i></a>";
            }
        @endphp

        <div class="table-responsive shadow-sm rounded" style="max-height: 65vh; overflow-y: auto;">
            <table class="table table-bordered text-center align-middle custom-table" style="min-width: 1100px;">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>{!! sortHeader('Phân loại', 'category') !!}</th>
                        <th>{!! sortHeader('Mã Serial', 'serial_number') !!}</th>
                        <th>{!! sortHeader('Tình trạng', 'condition') !!}</th>
                        <th>{!! sortHeader('Địa chỉ', 'location') !!}</th>
                        <th>{!! sortHeader('Mô tả', 'description') !!}</th>
                        <th>{!! sortHeader('Trạng thái', 'status') !!}</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($components as $component)
                        <tr>
                            <td class="text-start">{{ $component->category }}</td>
                            <td class="text-start">{{ $component->serial_number }}</td>
                            <td class="text-start"><span class="badge bg-primary">{{ $component->condition }}</span></td>
                            <td class="text-start">{{ $component->location }}</td>
                            <td class="text-start text-truncate" style="max-width: 200px;">{{ $component->description }}
                            </td>
                            <td class="text-start {{ $component->status === 'Sẵn kho' ? 'text-success' : 'text-danger' }}">
                                {{ $component->status }}
                            </td>
                            <td>
                                @if ($component->status === 'Sẵn kho')
                                    <a href="{{ route('components.exportConfirm', $component->id) }}"
                                        class="btn btn-sm btn-success mb-1">
                                        <i class="far fa-minus-square me-1"></i> Xuất kho
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-danger mb-1" disabled>
                                        <i class="fas fa-minus-circle me-1"></i> Đã xuất
                                    </button>
                                @endif
                                <a href="{{ route('components.show', $component->id) }}" class="btn btn-sm btn-info mb-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('components.edit', $component->id) }}"
                                    class="btn btn-sm btn-warning mb-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('components.destroy', $component->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xoá [{{ $component->serial_number }}]?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mb-1">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $components->links() }}
        </div>
    </div>

    {{-- Style --}}
    <style>
        .custom-table th {
            position: sticky;
            top: 0;
            background-color: #4b6cb7 !important;
            z-index: 2;
        }

        .custom-table td,
        .custom-table th {
            vertical-align: middle;
            white-space: nowrap;
        }

        .custom-table tr:hover td {
            background-color: #f0f4ff !important;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
