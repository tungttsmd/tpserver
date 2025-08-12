<div class="row p-4 w-full">
    <!-- Cột phải: Thông tin -->
    <div class="p-0 w-full md:w-1/2 p-4 h-full flex flex-col gap-12">
        <div class="flex-1 basis-4/5 overflow-y-auto">
            <div class="border rounded-xl p-4 bg-white">
                <h5 class="text-green-600 font-semibold mb-3 flex items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>Thông tin vị trí
                </h5>
                <ul class="text-sm divide-y divide-gray-200">
                    <li class="py-2"><strong>Tên:</strong> <span id="previewLocName">-</span></li>
                    <li class="py-2"><strong>Ghi chú:</strong> <span id="previewLocNote">-</span></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Cột trái: Form nhập -->
    <div class="col-md-6 border-end">
        <form wire:submit.prevent="createLocation" id="locationForm">
            <div class="mb-3">
                <label class="form-label">Tên vị trí<span class="text-red-500">*</span></label>
                <input wire:model.defer="name" type="text" name="name" class="form-control border rounded p-2"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ghi chú</label>
                <textarea wire:model.defer="note" name="note" class="form-control border rounded p-2" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success px-4 py-2 rounded text-white bg-green-600 hover:bg-green-700">
                <i class="fas fa-save mr-2"></i> Lưu vị trí
            </button>
        </form>
    </div>
</div>

<script>
    const locForm = document.getElementById('locationForm');
    locForm.addEventListener('input', () => {
        document.getElementById('previewLocName').textContent = locForm.name.value || '-';
        document.getElementById('previewLocNote').textContent = locForm.note.value || '-';
    });
</script>
