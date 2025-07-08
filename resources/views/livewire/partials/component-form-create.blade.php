  <div class="card-header bg-main text-white text-center rounded-top-4">
      <h4 class="mb-0"><i class="fas fa-plus mr-2"></i> Thêm linh kiện mới</h4>
  </div>

  <div class="card-body">
      <div class="row">
          {{-- QR CODE + THÔNG TIN LINH KIỆN BÊN PHẢI --}}
          <div class="col-md-6 d-flex flex-column align-items-center justify-content-start">
              <div class="w-100 d-flex flex-column" style="height: 500px;">
                  <div
                      class="flex-grow-1 d-flex align-items-center justify-content-center mb-4 qr-frame {{ session('successData') ? '' : 'opacity-50' }}">
                      <img src="{{ session('successData.link_qr') ?? asset('img/qrcode-default.jpg') }}"
                          alt="{{ session('successData') ? 'QR Code' : 'QR Placeholder' }}" class="img-fluid"
                          style="padding: 40px">
                      @if (!session('successData'))
                          <p>QR code here</p>
                      @endif
                  </div>

                  @if (session('successData'))
                      <div class="alert alert-success d-flex align-items-center" role="alert">
                          <i class="fas fa-info-circle mr-2"></i>
                          <div>
                              <strong>Thêm mới thành công!</strong>
                          </div>
                      </div>
                      <div class="border rounded p-3 bg-white shadow-sm mt-auto detail-container">
                          <h5 class="text-success mb-3"><i class="fas fa-info-circle mr-3"></i>Thông
                              tin
                              linh kiện</h5>
                          <ul class="list-group list-group-flush">
                              @foreach (['serial_number' => 'Serial', 'category' => 'Phân loại', 'location' => 'Vị trí', 'condition' => 'Tình trạng', 'status' => 'Trạng thái', 'description' => 'Mô tả'] as $key => $label)
                                  <li class="list-group-item" style="white-space: normal; overflow-wrap: break-word;">
                                      <strong>{{ $label }}:</strong>
                                      {{ session('successData')[$key] }}
                                  </li>
                              @endforeach
                              <li class="list-group-item" style="white-space: normal; overflow-wrap: break-word;">
                                  <strong>Ngày tạo: </strong>{{ now() }}
                              </li>
                          </ul>
                      </div>
                  @else
                      <p class="text-muted mt-auto text-center"><i class="fas fa-info-circle mr-2"></i>Thông tin sẽ hiển
                          thị sau khi thêm
                          mới
                      </p>
                  @endif
              </div>
          </div>

          {{-- FORM BÊN TRÁI --}}
          <div class="col-md-6 border-end">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

              <form wire.submit.prevent="formHandlerRequest">
                  @csrf

                  {{-- SERIAL NUMBER tách riêng để thêm autofocus --}}
                  <x-form.components.serial x-data="{ serial: '{{ old('serial_number') }}', generate() { this.serial = 'SN' + Math.random().toString(36).substring(2, 12).toUpperCase(); } }" />


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
                              'name' => 'category',
                              'label' => 'Phân loại',
                              'icon' => 'fas fa-cogs',
                              'type' => 'select',
                              'options' => $categoryOptions,
                          ],
                          [
                              'name' => 'condition',
                              'label' => 'Tình trạng',
                              'icon' => 'fas fa-microchip',
                              'type' => 'select',
                              'options' => $conditionOptions,
                          ],
                          [
                              'name' => 'location',
                              'label' => 'Vị trí',
                              'icon' => 'fas fa-map-marker-alt',
                              'type' => 'select',
                              'options' => $locationOptions,
                          ],
                          [
                              'name' => 'vendor',
                              'label' => 'Nhà cung cấp',
                              'icon' => 'fas fa-store',
                              'type' => 'select',
                              'options' => $vendorOptions,
                          ],
                      ];
                  @endphp
                  Tên linh kiện: <input type="text">
                  @foreach ($fields as $field)
                      <div class="mb-3">
                          <input wire:model.defer="serialNumber" type="text">
                          <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="{{ $field['icon'] }}"></i></span>
                              <select name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                  class="form-control input-hover" required>
                                  <option value="">-- Chọn {{ strtolower($field['label']) }} --
                                  </option>
                                  @foreach ($field['options'] as $option)
                                      <option value="{{ $option }}"
                                          {{ old($field['name']) == $option ? 'selected' : '' }}>
                                          {{ $option }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                  @endforeach
                  <div class="mb-3">
                      <label for="imported_at" class="form-label">Ngày nhập hàng</label>
                      <div class="input-group">
                          <span class="input-group-text icon-scale"><i class="fas fa-calendar-alt"></i></span>
                          <input type="date" name="imported_at" id="imported_at" class="form-control input-hover"
                              required value="{{ old('imported_at', date('Y-m-d')) }}">
                      </div>
                  </div>
                  <div class="mb-3">
                      <label for="warranty_months" class="form-label">Bảo hành (tháng)</label>
                      <div class="input-group">
                          <span class="input-group-text icon-scale"><i class="fas fa-shield-alt"></i></span>
                          <input type="number" min="0" name="warranty_months" id="warranty_months"
                              class="form-control input-hover" value="{{ old('warranty_months', 0) }}"
                              placeholder="Nhập số tháng bảo hành">
                      </div>
                  </div>

                  {{-- MÔ TẢ --}}
                  <div class="mb-3">
                      <label for="description" class="form-label">Mô tả</label>
                      <textarea name="description" id="description" rows="3" class="form-control input-hover">{{ old('description', 'Lưu trữ thông tin') }}</textarea>
                  </div>

                  {{-- TRẠNG THÁI MẶC ĐỊNH --}}
                  <input type="hidden" name="status" value="Sẵn kho">

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
