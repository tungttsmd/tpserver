class ItemScanView {
    constructor(options = {}) {
        this.manualInputId = options.manualInputId || 'scanInputFocus';
        this.manualFormId = options.manualFormId || 'formTriggerLivewire';
        this.validKeyRegex = options.validKeyRegex || /^[a-zA-Z0-9]$/;
        this.currentFilter = 'realtime';
        this.manualQueue = null; // dùng để lưu serialNumber nếu cần focus sau render
        this.init();
    }

    init() {
        // Bắt phím bấm
        document.addEventListener('keydown', (e) => this.handleKeyDown(e));

        // Livewire hook
        document.addEventListener('livewire:load', () => {
            Livewire.hook('message.processed', () => {
                // Nếu có serialNumber trong queue → set value và focus
                if (this.manualQueue) {
                    this.setManualInput(this.manualQueue);
                    this.manualQueue = null;
                }

                // Tự động select input khi đang ở chế độ manual
                if (this.currentFilter === 'manual') {
                    this.focusManualInput();
                }
            });
        });
    }

    getManualInput() {
        return document.getElementById(this.manualInputId);
    }

    getManualForm() {
        return document.getElementById(this.manualFormId);
    }

    focusManualInput() {
        const input = this.getManualInput();
        if (input) input.select();
    }

    setManualInput(serialNumber) {
        const input = this.getManualInput();
        if (input) {
            input.value = serialNumber;
            input.focus();
            input.select();
        }
    }

    handleKeyDown(e) {
        const active = document.activeElement;
        if (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA') return;

        if (this.validKeyRegex.test(e.key)) {
            if (this.currentFilter !== 'manual') {
                Livewire.emit('filter', 'manual');
                this.currentFilter = 'manual';
            }
            this.focusManualInput();
        }
    }

    triggerManualScan(serialNumber) {
        Livewire.emit('filter', 'manual');
        this.currentFilter = 'manual';

        // Lưu vào queue để xử lý focus sau Livewire render
        this.manualQueue = serialNumber;

        // Submit form khi render xong
        const form = this.getManualForm();
        if (form) {
            form.addEventListener('livewire:load', () => {
                form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
            });
        }
    }

    triggerRealtimeScan(serialNumber) {
        Livewire.emit('filter', 'realtime');
        this.currentFilter = 'realtime';

        // Set trực tiếp giá trị realtime
        const livewireId = document.querySelector('[wire\\:id]')?.getAttribute('wire:id');
        if (livewireId) {
            Livewire.find(livewireId).set('serialNumber', serialNumber);
        }
    }
}
