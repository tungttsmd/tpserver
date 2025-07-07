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
    public $component = null;
    public $qrcode = null;
    protected $suggestions = null;
    public $serialNumber = null;
    protected $listeners = ['scanRequest' => 'scanResponse'];
    public function scanResponse($serialNumber)
    {
        $this->serialNumber = trim($serialNumber);

        // 1. Lấy chính xác 100%
        $this->component = HardwareComponent::with([
            'category',
            'vendor',
            'condition',
            'location',
            'manufacturer',
            'status'
        ])->where('serial_number', $this->serialNumber)->first();

        // 2. QR code
        $this->qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$this->serialNumber}&size=240x240";

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
    public function getSuggestionsProperty()
    {
        if (!$this->serialNumber)
            return collect();

        $prefixLength = floor(strlen($this->serialNumber) * 0.5);
        $prefix = substr($this->serialNumber, 0, $prefixLength);

        return HardwareComponent::with('category', 'status')
            ->where('serial_number', 'like', $prefix . '%')
            ->when($this->component, fn($q) => $q->where('id', '!=', $this->component->id))
            ->orderBy('serial_number')
            ->paginate(20);
    }
}
