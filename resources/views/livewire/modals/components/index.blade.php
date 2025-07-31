{{-- Popup hidden mặc định --}}
<div id="popup-overlay" style="display: none; position: fixed; top: 0; left: 0;
    width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;
    justify-content: center; align-items: center;">
    <div class="tpserver container max-w-[768px]">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg rounded-md">
                    <div
                        class="flex items-center justify-content-between pl-4 pr-2 py-2 bg-{{ $modalColor }} text-center rounded-t-md">
                        <h4 class="mb-0"><i class="{{ $modalIcon }} me-2"></i>{{ $modalTitle }}</h4>
                        <button type="button" onclick="closePopup()" class="btn btn-danger">
                            <i class="fas fa-times me-1"></i> Đóng
                        </button>
                    </div>

                    <div class="card-body bg-light-subtle border rounded-b-md">

                        {{-- Form --}}
                        @if ($controller === 'components')
                            @if ($modalType === 'edit')
                                <livewire:features.components.component-edit-livewire :component-id="$recordId" />
                            @elseif ($modalType === 'show')
                                <livewire:features.components.component-show-livewire :component-id="$recordId" />
                            @elseif ($modalType === 'stockout')
                                <livewire:features.components.component-stockout-livewire :component-id="$recordId" />
                            @elseif ($modalType === 'stockreturn')
                                <livewire:features.components.component-stockreturn-livewire :component-id="$recordId" />
                            @endif
                        @elseif ($controller === 'customers')

                            @if ($modalType === 'edit')
                                <livewire:features.customers.customer-edit-livewire :customer-id="$recordId" />
                            @elseif ($modalType === 'show')
                                <livewire:features.customers.customer-show-livewire :customer-id="$recordId" />
                            @endif
                        @else
                            <div class="bg-main">
                                <p>Không tìm thấy modal</p>
                            </div>
                        @endif
                        <div class="flex flex-row">
                            <p>{{$controller}} || {{$action}} || {{$filter}}</p>
                        </div>
                        <link rel="stylesheet" href="{{ asset('css/components/modal.css') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
