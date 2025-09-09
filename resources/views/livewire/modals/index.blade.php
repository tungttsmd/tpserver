{{-- Popup hidden mặc định --}}
<div id="popup-overlay"
    class="hidden pt-[4vw] fixed top-0 left-0 w-full h-full bg-black bg-opacity-10 z-[999] flex justify-center">
    <div class="max-w-[1140px] bg-white border border-beige rounded-lg p-4 h-fit flex flex-col">
        <div class="flex justify-end mb-4">
            <button type="button" onclick="closePopup()" class="text-red-600 ">
                <i class="fas fa-times mr-1"></i> Đóng
            </button>
        </div>
        <div>
            @if ($modalRoute[0] === 'item')
                @if ($modalType === 'edit')
                    <livewire:features.components.component-edit-livewire :component-id="$recordId" />
                @elseif ($modalType === 'show')
                    <livewire:features.components.component-show-livewire :component-id="$recordId" />
                @elseif ($modalType === 'stockout')
                    <livewire:features.components.component-stockout-livewire :component-id="$recordId" />
                @elseif ($modalType === 'stockreturn')
                    <livewire:features.components.component-stockreturn-livewire :component-id="$recordId" />
                @endif
            @elseif ($modalRoute[0] === 'customer')
                @if ($modalType === 'edit')
                    <livewire:features.customers.customer-edit-livewire :customer-id="$recordId" />
                @elseif ($modalType === 'show')
                    <livewire:features.customers.customer-show-livewire :customer-id="$recordId" />
                @endif
            @elseif ($modalRoute[0] === 'location')
                @if ($modalType === 'edit')
                    <livewire:features.locations.location-edit-livewire :location-id="$recordId" />
                @elseif ($modalType === 'show')
                    <livewire:features.locations.location-show-livewire :location-id="$recordId" />
                @endif
            @elseif ($modalRoute[0] === 'vendor')
                @if ($modalType === 'edit')
                    <livewire:features.vendors.vendor-edit-livewire :vendor-id="$recordId" />
                @elseif ($modalType === 'show')
                    <livewire:features.vendors.vendor-show-livewire :vendor-id="$recordId" />
                @endif
            @elseif ($modalRoute[0] === 'log')
                <livewire:features.components.component-show-livewire :component-id="$recordId" />
            @else
                <div class="bg-main">
                    <p>Không tìm thấy modal</p>
                </div>
            @endif
            <!-- <link rel="stylesheet" href="{{ asset('css/components/modal.css') }}"> -->
        </div>
    </div>

    <script>
        const popupOverlay = document.getElementById('popup-overlay');

        function showPopup() {
            if (popupOverlay) {
                popupOverlay.style.display = 'flex';
            }
        }

        window.closePopup = function () {
            if (popupOverlay) {
                popupOverlay.style.display = 'none';
            }
        }

        window.addEventListener('modal-show', event => {
            showPopup();
        });

        // Listen for closePopup event from Livewire components
        window.addEventListener('closePopup', event => {
            closePopup();
        });

        // Đóng modal khi nhấn phím Escape
        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                closePopup();
            }
        });

        // Đóng modal khi click ra ngoài
        popupOverlay.addEventListener('click', function (event) {
            // Chỉ đóng khi click vào chính overlay, không phải các element con
            if (event.target === this) {
                closePopup();
            }
        });
    </script>
</div>