@props([
    'querySelector' => '#serial-number.form-create',
    'name' => 'serial_number',
    'value' => old('serial_number'),
    'label' => 'Serial number',
    'placeholder' => 'Nhập số serial chính xác (ví dụ: SN123456789)',
])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
        <input type="text" name="{{ $name }}" id="serial-number"
            class="form-create form-control input-hover rounded" value="{{ $value }}"
            placeholder="{{ $placeholder }}" required autofocus {{ $attributes }}>
        <button type="button"
            class="btn btn-primary bg-main ml-2"
            onclick="generateCode(this)"
            data-target="{{ $querySelector }}">
            Tạo mã ngẫu nhiên
        </button>
    </div>
    <p class="mt-2 fw-bold" id="code-output-{{ $name }}"></p>
</div>
@once
<script>
    function generateCode(btn) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let code = '';
        let length = 12;
        for (let i = 0; i < length; i++) {
            if (i % 4 === 0) {
                code += '-';
            } else {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
        }

        const selector = btn.dataset.target;
        const input = document.querySelector(selector);
        if (input) {
            const fullCode = 'TPSC' + code;
            input.value = fullCode;
            input.focus();

            // Optional: hiển thị kết quả ở dưới (nếu có element output đi kèm)
            const output = document.querySelector(`#code-output-${input.name}`);
            if (output) {
                output.textContent = fullCode;
            }
        }
    }
</script>
@endonce
