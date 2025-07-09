<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Component as HardwareComponent;
use App\Models\Condition;
use App\Models\Location;
use App\Models\UserLog;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComponentForm extends Component
{
    use WithPagination;
    public $serial_number, $category_id, $vendor_id, $location_id, $condition_id, $status_id, $name, $date_issued, $warranty_start, $warranty_end, $note;
    public $category;
    public $vendor;
    public $location;
    public $condition;
    public $status;
    public $description;
    public $currentView = 'component-form-scan'; // view mặc định
    public $view_form_content = '';
    public $serialNumber = null;
    protected $listeners = ['scanRequest' => 'scanResponse', 'setScanModeRequest' => 'setScanModeResponse', 'formCreateRequest' => 'formCreateResponse'];
    public $mode = 'manual';
    public $successData = null;

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
        $handler = [];
        if ($this->view_form_content === 'livewire.partials.component-form-scan') {
            $handler = $this->formScanHandler();
        } else {
            $handler = $this->loadCreateFormData();
        }
        return view('livewire.component-form', $handler);
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
    public function formScanHandler()
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
        return [
            'component' => $component,
            'qrcode' => $qrcode,
            'suggestions' => $suggestions,
        ];
    }
    public function loadCreateFormData()
    {
        $categories = Category::select('id', 'name')
            ->get();
        $conditions = Condition::select('id', 'name')
            ->get();
        $locations = Location::select('id', 'name')
            ->get();
        $vendors = Vendor::select('id', 'name')
            ->get();
        return ['categories' => $categories, 'conditions' => $conditions, 'vendors' => $vendors, 'locations' => $locations];
    }
    public function rules()
    {
        return [
            'serial_number'   => 'required|unique:components,serial_number',
            'name'            => 'required|string|max:255',
            'category_id'        => 'required|exists:categories,id',
            'condition_id'       => 'required|exists:conditions,id',
            'location_id'        => 'required|exists:locations,id',
            'vendor_id'          => 'required|exists:vendors,id',
            'note'            => 'nullable|string|max:1000',
            'date_issued'     => 'required|date',
            'warranty_start'  => 'required|date',
            'warranty_end'    => 'required|date|after_or_equal:warranty_start',
        ];
    }
    public function formCreateSubmit()
    {

        $this->validate();

        $qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$this->serialNumber}&size=240x240" ?? asset('img/qrcode-default.jpg');

        $component = HardwareComponent::create([
            'serial_number'   => $this->serial_number,
            'name'            => $this->name,
            'category_id'     => $this->category,
            'condition_id'    => $this->condition,
            'location_id'     => $this->location,
            'vendor_id'       => $this->vendor,
            'date_issued'     => $this->date_issued,
            'warranty_start'  => $this->warranty_start,
            'warranty_end'    => $this->warranty_end,
            'note'     => $this->note,
        ]);

        $this->successData = [
            'serial_number' => $component->serial_number,
            'category'      => $component->category->name ?? '',
            'condition'     => $component->condition->name ?? '',
            'location'      => $component->location->name ?? '',
            'vendor'        => $component->vendor->name ?? '',
            'status'        => $component->status ?? 'N/A',
            'note'   => $component->note,
            'qrcode'       => $qrcode,
        ];

        $this->resetExcept('successData');
    }
}
