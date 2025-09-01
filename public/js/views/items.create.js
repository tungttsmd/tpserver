class ItemCreateView {
    constructor(options = {}) {
        this.formSelector = options.formSelector || 'form';
        this.stockinAtId = options.stockinAtId || 'stockin_at';
        this.warrantyStartId = options.warrantyStartId || 'warranty_start';
        this.warrantyCheckboxId = options.warrantyCheckboxId || 'has_warranty';
        this.warrantyFieldsId = options.warrantyFieldsId || 'warranty-fields';
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => this.setup());
        document.addEventListener('livewire:load', () => {
            Livewire.hook('message.processed', () => {
                this.setup();
            });
        });
    }

    getStockinInput() {
        return document.getElementById(this.stockinAtId);
    }

    getWarrantyStartInput() {
        return document.getElementById(this.warrantyStartId);
    }

    getWarrantyCheckbox() {
        return document.getElementById(this.warrantyCheckboxId);
    }

    getWarrantyFields() {
        return document.getElementById(this.warrantyFieldsId);
    }

    getForm() {
        return document.querySelector(this.formSelector);
    }

    setup() {
        const stockinInput = this.getStockinInput();
        const warrantyStart = this.getWarrantyStartInput();
        const warrantyCheckbox = this.getWarrantyCheckbox();
        const warrantyFields = this.getWarrantyFields();

        if (stockinInput && warrantyStart) {
            warrantyStart.value = warrantyCheckbox.checked ? stockinInput.value : '';
            stockinInput.addEventListener('change', () => {
                warrantyStart.value = stockinInput.value;
            });
        }

        if (warrantyCheckbox && warrantyFields) {
            // Ẩn/hiện dựa trên checkbox
            const updateDisplay = () => {
                warrantyFields.style.display = warrantyCheckbox.checked ? 'flex' : 'none';
                if (warrantyCheckbox.checked && stockinInput) {
                    warrantyStart.value = stockinInput.value;
                }
            };

            warrantyCheckbox.addEventListener('change', updateDisplay);

            // Thực hiện 1 lần để set đúng trạng thái ban đầu mà không nhảy UI
            updateDisplay();
        }
    }

    resetForm() {
        const form = this.getForm();
        if (form) form.reset();

        const stockinInput = this.getStockinInput();
        if (stockinInput) {
            const today = new Date().toISOString().split('T')[0];
            stockinInput.value = today;
        }

        const warrantyFields = this.getWarrantyFields();
        if (warrantyFields) warrantyFields.style.display = 'none';

        const warrantyCheckbox = this.getWarrantyCheckbox();
        if (warrantyCheckbox) warrantyCheckbox.checked = false;
    }
}
