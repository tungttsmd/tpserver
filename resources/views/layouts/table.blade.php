  <div class="container">

      {{-- Bộ lọc --}}
      <form method="GET" action="{{ route('components.index') }}" class="mb-4">
          <div class="row g-3 align-items-end" style="gap: 20px">

              <div class="card-body card mb-0 mt-4">
                  <div class="row align-items-center g-2">

                      <div class="col-md-4 d-flex gap-2">
                          <a href="{{ route('components.index') }}" class="btn btn-danger w-100">
                              <i class="fas fa-undo me-1"></i>
                          </a>
                          <button type="submit" class="btn w-100 text-white" style="background-color:#4b6cb7">
                              <i class="fas fa-search text-white"></i>
                          </button>
                      </div>

                      <div class="col-md-8 d-flex align-items-center">
                          <input type="text" name="search" class="form-control shadow-sm flex-grow-1"
                              value="{{ request('search') }}" placeholder="Tìm kiếm Serial hoặc Mô tả.">
                      </div>

                  </div>
              </div>

              <div class="card-body d-flex flex-row card mb-0 mt-4">

                  <div class="col-md-3 d-flex flex-column">
                      <label class="form-label fw-semibold">Phân loại</label>
                      <select name="category" class="form-select shadow-sm">
                          <option value="">Tất cả</option>
                          @foreach (['RAM', 'Chip', 'VGA', 'Main', 'Nguồn', 'Quạt', 'Khác'] as $cat)
                              <option value="{{ $cat }}" @selected(request('category') == $cat)>{{ $cat }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  <div class="col-md-3 d-flex flex-column">
                      <label class="form-label fw-semibold">Tình trạng</label>
                      <select name="condition" class="form-select shadow-sm">
                          <option value="">Tất cả</option>
                          @foreach (['Mới', 'Cũ', 'Hư'] as $cond)
                              <option value="{{ $cond }}" @selected(request('condition') == $cond)>{{ $cond }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  <div class="col-md-3 d-flex flex-column">
                      <label class="form-label fw-semibold">Trạng thái</label>
                      <select name="status" class="form-select shadow-sm">
                          <option value="">Tất cả</option>
                          @foreach (['Sẵn kho', 'Đã xuất'] as $status)
                              <option value="{{ $status }}" @selected(request('status') == $status)>{{ $status }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  <div class="col-md-3 d-flex flex-column">
                      <label class="form-label fw-semibold">Hiển thị</label>
                      <select name="perPage" class="form-select shadow-sm">
                          @foreach ([20, 50, 80, 100, 200] as $size)
                              <option value="{{ $size }}" @selected(request('perPage', 20) == $size)>{{ $size }}
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
      <div class="table-responsive shadow-sm rounded" style="max-height: 65vh ; overflow-y: auto;">
          <table class="table table-bordered text-center align-middle custom-table" style="min-width: 1140px;">
              <thead class="bg-primary text-white">
                  <tr>
                      <th>{!! sortHeader('Mã Serial', 'serial_number') !!}</th>
                      <th>{!! sortHeader('Phân loại', 'category') !!}</th>
                      <th>{!! sortHeader('Tình trạng', 'condition') !!}</th>
                      <th>{!! sortHeader('Vị trí', 'location') !!}</th>
                      <th>{!! sortHeader('Cập nhật', 'updated_at') !!}</th>
                      <th>{!! sortHeader('Trạng thái', 'status') !!}</th>
                      <th>Hành động</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($components as $component)
                      <tr>
                          <td class="text-start">{{ $component->serial_number }}</td>
                          <td class="text-start">{{ $component->category }}</td>
                          <td class="text-start"><span class="badge bg-primary">{{ $component->condition }}</span></td>
                          <td class="text-start">{{ $component->location }}</td>
                          <td class="text-start">{{ $component->updated_at }}</td>
                          <td
                              class="text-start {{ $component->status === 'Sẵn kho' ? 'text-success' : 'text-danger' }}">
                              {{ $component->status }}
                          </td>
                          <td>
                              <a href="{{ route('components.show', $component->id) }}"
                                  class="btn btn-sm btn-info mb-1">
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

  <style>
      .custom-table {
          border-collapse: collapse;
          width: 100%;
      }

      /* Header */
      .custom-table thead th {
          position: sticky;
          top: 0;
          background-color: #4b6cb7;
          color: white;
          z-index: 10;
          white-space: nowrap;
          vertical-align: middle;
          border: 1px solid #dee2e6;
          padding: 8px 12px;
      }

      /* Body cells */
      .custom-table tbody td {
          background-color: #fff;
          border: 1px solid #dee2e6;
          color: #212529;
          white-space: nowrap;
          vertical-align: middle;
          padding: 8px 12px;
      }

      /* Hover effect */
      .custom-table tbody tr:hover td {
          background-color: #f8f9fa;
      }

      /* Optional: truncate text with ellipsis */
      .text-truncate {
          max-width: 150px;
          /* bạn chỉnh tùy ý */
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
      }
  </style>
