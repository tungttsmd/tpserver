class ItemCreateView {
    constructor(options = {}) {
        this.formSelector = options.formSelector || 'form';
        this.stockinAtId = options.stockinAtId || 'stockin_at';
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
        // Lắng nghe event success từ Livewire để reset form
        window.addEventListener('form-submit-success', () => {
            this.resetForm();
        });
    }

    getStockinInput() {
        return document.getElementById(this.stockinAtId);
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
        const warrantyCheckbox = this.getWarrantyCheckbox();
        const warrantyFields = this.getWarrantyFields();

        if (warrantyCheckbox && warrantyFields) {
            const updateDisplay = () => {
                warrantyFields.style.display = warrantyCheckbox.checked ? 'flex' : 'none';
                
                // Emit event để Livewire xử lý logic warranty
                if (warrantyCheckbox.checked) {
                    window.Livewire.emit('toggleWarranty', true);
                } else {
                    window.Livewire.emit('toggleWarranty', false);
                }
            };

            warrantyCheckbox.addEventListener('change', updateDisplay);
            updateDisplay(); // Gọi khi setup để khởi tạo giá trị ban đầu
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