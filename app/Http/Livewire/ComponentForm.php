<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Component as HardwareComponent;

class ComponentForm extends Component
{
    use WithPagination;

    public $currentView = 'component-form-scan'; // view mặc định
    public $view_form_content = '';
    public $serialNumber = null;
    protected $listeners = ['scanRequest' => 'scanResponse', 'setScanModeRequest' => 'setScanModeResponse'];
    public $mode = 'manual';

    public function formRenderTrigger()
    {
        // Hàm này là hàm rỗng nhằm chỉ để kích hoạt lại render của livewire khi submit form chuẩn mà không realtime
    }

    public function setScanModeResponse($mode)
    {
        $this->mode = $mode;
    }
    public function render()
    {
        if ($this->serialNumber) {

            $this->serialNumber = trim($this->serialNumber);

            // 1. Lấy chính xác 100%
            $component = HardwareComponent::with([
                'category',
                'vendor',
                'condition',
                'location',
                'manufacturer',
                'status'
            ])->where('serial_number', $this->serialNumber)->first();
            $qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$this->serialNumber}&size=240x240";

            // Phương pháp search đề xuất thông minh
            $suggestions = $this->smartMatching($component);
        } else {
            $suggestions = null;
            $qrcode = null;
            $component = null;
        }

        return view('livewire.component-form', [
            'component' => $component,
            'qrcode' => $qrcode,
            'suggestions' => $suggestions,
        ]);
    }
    public function mount($form)
    {
        switch ($form) {
            case 'component-form-create':
                $this->view_form_content = 'livewire.partials.component-form-create';
                break;
            default:
                $this->view_form_content = 'livewire.partials.component-form-scan';
                break;
        }
    }
    public function smartMatching($component)
    {
        $serial = $this->serialNumber;

        $baseQuery = HardwareComponent::with('category', 'status')
            ->when($component, fn($q) => $q->where('id', '!=', $component->id));

        // 1. prefix
        $suggestions = (clone $baseQuery)
            ->where('serial_number', 'like', $serial . '%')
            ->orderBy('serial_number')
            ->paginate(20);

        // 2. chứa toàn bộ
        if ($suggestions->isEmpty()) {
            $suggestions = (clone $baseQuery)
                ->where('serial_number', 'like', '%' . $serial . '%')
                ->orderBy('serial_number')
                ->paginate(20);
        }

        // 3. nửa đầu
        if ($suggestions->isEmpty()) {
            $half = substr($serial, 0, floor(strlen($serial) * 0.5));
            $suggestions = (clone $baseQuery)
                ->where('serial_number', 'like', $half . '%')
                ->orderBy('serial_number')
                ->paginate(20);
        }

        // 4. nửa sau
        if ($suggestions->isEmpty()) {
            $half = substr($serial, floor(strlen($serial) * 0.5));
            $suggestions = (clone $baseQuery)
                ->where('serial_number', 'like', '%' . $half)
                ->orderBy('serial_number')
                ->paginate(20);
        }

        return $suggestions;
    }

}
