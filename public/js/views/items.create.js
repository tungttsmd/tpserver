class ItemCreateView {
    constructor(options = {}) {
        this.formSelector = options.formSelector || 'form';
        this.stockinAtId = options.stockinAtId || 'stockin_at';
        this.warrantyCheckboxId = options.warrantyCheckboxId || 'has_warranty';
        this.warrantyFieldsId = options.warrantyFieldsId || 'warranty-fields';
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.setup();
        });

        document.addEventListener('livewire:load', () => {
            Livewire.hook('message.processed', () => {
                this.setup();
            });
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

            // cleanup trước
            warrantyCheckbox.removeEventListener('change', warrantyCheckbox._listener || (() => {}));

            // gắn mới
            warrantyCheckbox._listener = updateDisplay;
            warrantyCheckbox.addEventListener('change', updateDisplay);
        }
    }
}
