<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Component as HardwareComponent;

class ComponentForm extends Component
{
    public $currentView = 'component-form-scan'; // view mặc định
    public $view_form_content = '';
    public $component = null;
    public $qrcode = null;
    public $suggestions = null;
    protected $listeners = ['scanRequest' => 'scanResponse'];
    public function scanResponse($serialNumber)
    {
        $serialNumber = trim($serialNumber);

        // 1. Lấy chính xác 100%
        $this->component = HardwareComponent::with([
            'category',
            'vendor',
            'condition',
            'location',
            'manufacturer',
            'status'
        ])->where('serial_number', $serialNumber)->first();

        // 2. QR code
        $this->qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$serialNumber}&size=240x240";

        // 3. Lấy 10 cái tương tự (loại trừ cái đã lấy ở trên)
        $prefixLength = floor(strlen($serialNumber) * 0.5);
        $prefix = substr($serialNumber, 0, $prefixLength);
        
        $this->suggestions = HardwareComponent::with('category')
            ->where('serial_number', 'like', $prefix . '%') // tìm các serial bắt đầu bằng 50% đầu
            ->when($this->component, fn($q) => $q->where('id', '!=', $this->component->id))
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.component-form');
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
}
