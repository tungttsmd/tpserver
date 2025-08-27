@props([
    'warrantyStart' => '',
    'warrantyEnd' => ''
])

<div class="mb-3">
    <div class="form-check">
        <input 
            class="form-check-input" 
            type="checkbox" 
            id="has_warranty"
        >
        <label class="form-check-label" for="has_warranty">
            <i class="fas fa-shield-alt me-2"></i>Linh kiện có bảo hành
        </label>
    </div>
</div>

<div id="warranty-fields" class="row" style="display: none;">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="warranty_start" class="form-label">Ngày bắt đầu bảo hành</label>
            <input 
                type="date" 
                class="form-control" 
                id="warranty_start"
                wire:model.defer="warranty_start"
                value="{{ $warrantyStart }}"
            >
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="warranty_end" class="form-label">Ngày kết thúc bảo hành</label>
            <input 
                type="date" 
                class="form-control" 
                id="warranty_end"
                wire:model.defer="warranty_end"
                value="{{ $warrantyEnd }}"
            >
        </div>
    </div>
</div>
