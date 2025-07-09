  <div class="card-header bg-main text-white text-center rounded-top-4">
      <h4 class="mb-0"><i class="fas fa-plus mr-2"></i> Thêm linh kiện mới</h4>
  </div>

  <div class="card-body">
      <div class="row">
          {{-- QR CODE + THÔNG TIN LINH KIỆN BÊN PHẢI --}}
          <div class="md:w-1/2 w-full flex flex-col items-center justify-start">
              <div class="pr-4 pl-4 w-full flex flex-col h-[500px]">

                  {{-- Khung QR --}}
                  <div
                      class="d-flex flex-column flex-grow items-center justify-center mb-4 border border-dashed rounded-xl relative transition-opacity duration-300 qr-frame {{ session('successData') ? '' : 'opacity-50' }}">
                      <img src="{{ session('successData.link_qr') ?? asset('img/qrcode-default.jpg') }}"
                          class="max-w-full max-h-full p-10 object-contain" alt="QR Code">
                      @unless (session('successData'))
                          <p class="text-gray-500 text-center">QR code here</p>
                      @endunless
                  </div>

                  {{-- Alert thông báo --}}
                  @if (session('successData'))
                      <div
                          class="flex items-center bg-green-100 text-green-800 text-sm font-medium px-4 py-3 rounded shadow-sm">
                          <i class="fas fa-check-circle mr-2"></i>
                          <span><strong>Thêm mới thành công!</strong></span>
                      </div>

                      {{-- Thông tin chi tiết --}}
                      <div class="border rounded-lg p-4 bg-white shadow mt-auto detail-container">
                          <h5 class="text-green-600 font-semibold mb-2 flex items-center">
                              <i class="fas fa-info-circle mr-2"></i>Thông tin linh kiện
                          </h5>
                          <ul class="divide-y divide-gray-200 text-sm">
                              @foreach ([
        'serial_number' => 'Serial',
        'category' => 'Phân loại',
        'location' => 'Vị trí',
        'condition' => 'Tình trạng',
        'status' => 'Trạng thái',
        'description' => 'Mô tả',
    ] as $key => $label)
                                  <li class="py-2 break-words">
                                      <strong>{{ $label }}:</strong>
                                      {{ session('successData')[$key] ?? '-' }}
                                  </li>
                              @endforeach
                              <li class="py-2 break-words">
                                  <strong>Ngày tạo:</strong> {{ now()->format('d/m/Y H:i') }}
                              </li>
                          </ul>
                      </div>
                  @else
                      <p class="text-gray-500 text-center mt-auto text-sm">
                          <i class="fas fa-info-circle mr-2"></i>Thông tin sẽ hiển thị sau khi thêm mới
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

              <form wire:submit.prevent="formCreateSubmit">

                  {{-- SERIAL NUMBER tách riêng để thêm autofocus --}}
                  @props([
                      'name' => 'serial_number',
                      'label' => 'Serial number',
                      'placeholder' => 'Nhập số serial chính xác (ví dụ: SN123456789)',
                  ])
                  <div class="mb-1">
                      <label for="serial-number-{{ $name }}" class="form-label">{{ $label }}</label>
                      <div class="input-group">
                          <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                          <input wire:model.defer="{{ $name }}" type="text" name="{{ $name }}"
                              id="serial-number-generate" class="form-create form-control input-hover rounded mr-3"
                              placeholder="{{ $placeholder }}" autofocus {{ $attributes }}>
                      </div>
                      <p class="mt-2 fw-bold" id="code-output-{{ $name }}"></p>
                  </div>

                  {{-- CÁC FIELD CÒN LẠI --}}
                  @php

                      $categoryOptions = [];
                      $conditionOptions = [];
                      $locationOptions = [];
                      $vendorOptions = [];
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

                      $fields = [
                          [
                              'livewire' => 'category_id',
                              'name' => 'category',
                              'label' => 'Phân loại',
                              'icon' => 'fas fa-cogs',
                              'type' => 'select',
                              'options' => $categoryOptions,
                          ],
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
                  @endphp
                  <div class="mb-1 mt-1">
                      <label for="name" class="form-label">Tên linh kiện</label>
                      <div class="input-group">
                          <span class="input-group-text icon-scale"><i class="fas fa-tags"></i></span>
                          <input wire:model.defer="name" type="text" class="form-control input-hover" required
                              placeholder="Nhập tên linh kiện">
                      </div>
                  </div>
                  <div class="d-flex gap-3 flex-wrap">
                      {{-- Ngày nhập kho --}}
                      <div class="flex-grow-1" style="min-width: 200px;">
                          <label for="date_issued" class="form-label">Ngày nhập kho</label>
                          <div class="input-group">
                              <span class="input-group-text icon-scale"><i class="fas fa-calendar-alt"></i></span>
                              <input wire:model.defer="date_issued" type="date" class="form-control input-hover"
                                  required>
                          </div>
                      </div>

                      {{-- Nhà cung cấp --}}
                      <div class="flex-grow-1" style="min-width: 200px;">
                          <label for="{{ $vendorFields['name'] }}"
                              class="form-label">{{ $vendorFields['label'] }}</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="{{ $vendorFields['icon'] }}"></i></span>
                              <select wire:model.defer="{{ $vendorFields['livewire'] }}"
                                  id="{{ $vendorFields['name'] }}" class="form-control input-hover" required>
                                  <option value="">-- Chọn {{ strtolower($vendorFields['label']) }}
                                      --</option>
                                  @foreach ($vendorFields['options'] as $key => $option)
                                      <option value="{{ $key }}"
                                          {{ $vendorFields['name'] == $option ? 'selected' : '' }}>
                                          {{ $option }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                  </div>


                  @foreach ($fields as $keyId => $field)
                      <div class="mb-1 mt-1">
                          <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="{{ $field['icon'] }}"></i></span>
                              <select wire:model.defer="{{ $field['livewire'] }}" id="{{ $field['name'] }}"
                                  class="form-control input-hover" required>
                                  <option value="{{ $keyId }}">-- Chọn {{ strtolower($field['label']) }} --
                                  </option>
                                  @foreach ($field['options'] as $key => $option)
                                      <option value="{{ $key }}"
                                          {{ old($field['name']) == $option ? 'selected' : '' }}>
                                          {{ $option }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                  @endforeach

                  <div class="d-flex gap-3 flex-wrap">
                      <div class="flex-grow-1 min-w-[200px]">
                          <label for="warranty_start" class="form-label">Ngày bắt đầu bảo hành</label>
                          <div class="input-group">
                              <span class="input-group-text icon-scale"><i class="fas fa-shield-alt"></i></span>
                              <input wire:model.defer="warranty_start" type="date" id="warranty_start"
                                  class="form-control input-hover" required value="{{ $warranty_start }}">
                          </div>
                      </div>

                      <div class="flex-grow-1 min-w-[200px]">
                          <label for="warranty_end" class="form-label">Ngày kết thúc bảo hành</label>
                          <div class="input-group">
                              <span class="input-group-text icon-scale"><i class="fas fa-calendar"></i></span>
                              <input wire:model.defer="warranty_end" type="date" id="warranty_end"
                                  class="form-control input-hover" required value="{{ $warranty_end }}">
                          </div>
                      </div>
                  </div>


                  {{-- MÔ TẢ --}}
                  <div class="mb-1 mt-1">
                      <label for="note" class="form-label">Mô tả</label>
                      <textarea wire:model.defer="note" name="note" rows="3" class="form-control input-hover">'Tpserver lưu dữ liệu'</textarea>
                  </div>

                  {{-- NÚT --}}
                  <div class="gapflex d-flex gap-2">
                      <button type="submit" class="flex-fill btn bg-main btn-hover">
                          <i class="fas fa-plus me-2"></i> Thêm mới
                      </button>
                      <a type="button" class="flex-fill btn btn-secondary" href="{{ route('components.index') }}">
                          <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
                      </a>
                  </div>
              </form>

          </div>
      </div>
  </div>
