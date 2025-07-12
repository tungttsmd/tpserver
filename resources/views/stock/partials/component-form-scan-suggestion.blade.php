  {{-- Gợi ý tương tự --}}
  <div class="col-lg-6">
      @if ($suggestions)
          @if (count($suggestions))
              <h4 class="text-md font-semibold text-gray-500 mb-2">
                  <i class="fas fa-list mr-1 text-gray-500"></i> Các linh kiện tương tự:
              </h4>

              <div class="overflow-y-auto" style="max-height: 400px;">
                  <ul class="space-y-2">
                      @foreach ($suggestions as $item)
                          <li class="mt-2 d-flex flex-col gap-2 p-2 bg-gray-100 rounded shadow-sm">
                              <div class="d-inline-flex justify-content-between">
                                  <p class="mr-2 text-sm flex items-center text-gray-500 italic"><i
                                          class="fas fa-barcode mr-2 text-gray-500"></i>
                                      <span
                                          class="font-medium text-gray-500"><strong>{{ $item->serial_number }}</strong></span>
                                  </p>
                                  <p class="text-sm text-blue-700" style="color: #4b6cb7">
                                      <strong>{{ strtoupper($item->name) }}</strong><i
                                          class="fas fa-tags ml-2 text-blue-500" style="color: #4b6cb7"></i>
                                  </p>
                              </div>
                              <div class="d-flex justify-content-between flex-column flex-sm-row gap-2">

                                  <div class="d-inline-flex flex">

                                      <p class="mr-2 text-sm flex items-center text-green-500 italic"><i
                                              class="fas fa-cube mr-1 text-green-500"></i>
                                          Loại: {{ optional($item->category)->name }}
                                      </p>
                                      <p class="mr-2 text-sm flex items-center text-blue-500 italic"><i
                                              class="fas fa-layer-group mr-1 text-blue-500"></i>
                                          Trạng thái: {{ optional($item->status)->name }}
                                      </p>
                                      <p class="mr-2 text-sm flex items-center text-orange-500 italic"><i
                                              class="fas fa-file-import mr-1 text-orange-500"></i>
                                          Ngày tạo: {{ $item->date_created ?? 'N/A' }}
                                      </p>
                                  </div>

                              </div>
                              <div class="d-flex justify-between align-items-center">
                                  @php
                                      $start = \Carbon\Carbon::parse($item->warranty_start);
                                      $end = \Carbon\Carbon::parse($item->warranty_end);
                                      $months = $start->diffInMonths($end);
                                      $color = match (true) {
                                          $months <= 0 => 'red',
                                          $months > 48 => 'purple',
                                          $months > 36 => 'indigo',
                                          $months > 24 => 'blue',
                                          $months > 12 => 'green',
                                          $months > 6 => 'yellow',
                                          $months > 3 => 'orange',
                                          default => 'gray',
                                      };
                                  @endphp
                                  <strong class="text-{{ $color }}-700">
                                      <i class="fas fa-shield-alt mr-1 text-{{ $color }}-600"></i>
                                      Bảo hành: {{ $months }} tháng ({{ $start->format('d/m/Y') }} -
                                      {{ $end->format('d/m/Y') }})
                                  </strong>

                                  @if ($mode === 'manual')
                                      <a href="#" class="text-main bright-hover scale-hover"
                                          onclick="triggerManualScan('{{ $item->serial_number }}')">
                                          <i class="fas fa-eye m-0"></i> Xem
                                      </a>
                                  @else
                                      <a href="#" class="text-main bright-hover scale-hover"
                                          onclick="triggerRealtimeScan('{{ $item->serial_number }}')">
                                          <i class="fas fa-eye m-0"></i> Xem
                                      </a>
                                  @endif
                              </div>

                          </li>
                      @endforeach
                  </ul>
              </div>
              <div class="mt-2">
                  {{ $suggestions->links('livewire.pagination.arrow-paginator') }}
              </div>
          @else
              <p class="text-gray-500 italic text-md ml-4">Không có linh kiện tương tự.</p>
          @endif
      @endif
  </div>

  <script></script>
