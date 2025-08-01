<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Component as HardwareComponent;
use Livewire\Component;
use Livewire\WithPagination;

class ComponentShowLivewire extends Component
{
    use WithPagination;
    public $date_created, $serial_number, $category_id, $vendor_id, $location_id, $condition_id, $manufacturer_id, $status_id, $name, $date_issued, $warranty_start, $warranty_end, $note;
    public $view_form_content = '';
    public $serialNumber = null;
    public $previous_view = null;
    public $filter = 'manual';
    public $createSuccess = null;
    public $componentId, $component, $qrcode = null;

    public function render()
    {
        $this->scan();
        $suggestions = $this->smartMatching($this->component, $this->component->serial_number);
        return view('livewire.features.components.show', ['suggestions' => $suggestions]);
    }
    public function mount()
    {
        $this->component = HardwareComponent::with([
            'category',
            'vendor',
            'condition',
            'location',
            'manufacturer',
            'status'
        ])->where('id', 1)->first();
    }
    public function realtime()
    {
        if ($this->filter === 'realtime') {
            $this->trigger();
        }
    }
    public function trigger()
    {
        $this->emitSelf('$refresh');
    }
    public function filter($filter)
    {
        $this->filter = $filter;
    }
    public function scan()
    {
        $id = trim($this->componentId);

        // 1. Lấy chính xác 100%
        $this->component = HardwareComponent::with([
            'category',
            'vendor',
            'condition',
            'location',
            'manufacturer',
            'status'
        ])->where('id', $id)->first();
        $this->qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$this->component->serial_number}&size=240x240";
    }
    public function smartMatching($component, $serial)
    {
        $baseQuery = HardwareComponent::with('category', 'status')
            ->when($component, fn($q) => $q->where('id', '!=', $component->id));

        // 1. prefix
        $suggestions = (clone $baseQuery)
            ->where('serial_number', 'like', $serial . '%')
            ->orderBy('serial_number')
            ->paginate(10);

        // 2. chứa toàn bộ
        if ($suggestions->isEmpty()) {
            $suggestions = (clone $baseQuery)
                ->where('serial_number', 'like', '%' . $serial . '%')
                ->orderBy('serial_number')
                ->paginate(10);
        }

        // 3. nửa đầu
        if ($suggestions->isEmpty()) {
            $half = substr($serial, 0, floor(strlen($serial) * 0.5));
            $suggestions = (clone $baseQuery)
                ->where('serial_number', 'like', $half . '%')
                ->orderBy('serial_number')
                ->paginate(10);
        }

        // 4. nửa sau
        if ($suggestions->isEmpty()) {
            $half = substr($serial, floor(strlen($serial) * 0.5));
            $suggestions = (clone $baseQuery)
                ->where('serial_number', 'like', '%' . $half)
                ->orderBy('serial_number')
                ->paginate(10);
        }

        return $suggestions;
    }
}
