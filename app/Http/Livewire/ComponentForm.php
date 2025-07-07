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
    protected $listeners = ['scanRequest' => 'scanResponse'];

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

            $prefixLength = floor(strlen($this->serialNumber) * 0.5);
            $prefix = substr($this->serialNumber, 0, $prefixLength);

            $suggestions = HardwareComponent::with('category', 'status')
                ->where('serial_number', 'like', $prefix . '%')
                ->when($component, fn($q) => $q->where('id', '!=', $component->id))
                ->orderBy('serial_number')
                ->paginate(20);
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
}
