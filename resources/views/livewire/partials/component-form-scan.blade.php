   <div class="card-header bg-main text-white text-center rounded-top-4">
       <h4 class="mb-0"><i class="fas fa-plus mr-2"></i> Scan code linh kiện</h4>
   </div>

   <div class="card-body">
       <div class="row">
           @if (session('info'))
               <div class="alert alert-warning alert-dismissible fade show" role="alert">
                   <i class="fas fa-exclamation-circle me-2"></i> {{ session('info') }}
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                       <a type="button" class="flex-fill btn btn-secondary" href="{{ route('components.index') }}">
                           <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
                       </a>
                   </div>
               </form>

           </div>
       </div>
   </div>
