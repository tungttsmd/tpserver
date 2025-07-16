{{-- Popup hidden mặc định --}}
<div id="popup-overlay"
    style="display: none; position: fixed; top: 0; left: 0;
    width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;
    justify-content: center; align-items: center;">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg rounded-4">
                    <div class="card-header bg-main text-white text-center rounded-top-4">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i> Cập nhật thông tin linh kiện</h4>
                    </div>

                    <div class="card-body bg-light-subtle">
                        {{-- Hiển thị lỗi nếu có --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Ví dụ form --}}
                        <livewire:features.components.component-edit-livewire :component-id="1" />

                        <link rel="stylesheet" href="{{ asset('css/components/edit/edit.css') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
