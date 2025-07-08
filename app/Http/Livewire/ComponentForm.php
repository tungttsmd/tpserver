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
    public function formCreateResponse()
    {
        $validated = Validator::make([
            'serial_number' => $this->serialNumber,
            'category' => $this->category,
            'vendor' => $this->vendor,
            'location' => $this->location,
            'condition' => $this->condition,
            'status' => $this->status,
            'description' => $this->description,
        ], [
            'serial_number' => 'required|string|max:255|unique:components,serial_number',
            'category' => 'required|string|max:255',
            'vendor' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'nullable|string',
        ])->validate();

        try {
            $component = HardwareComponent::create($validated);

            UserLog::create([
                'action' => 'Thêm mới',
                'user' => Auth::user()->username ?? 'unknown',
                'note' => (Auth::user()->username ?? 'unknown') . " đã thêm mới {$this->category} [{$this->serialNumber}]"
            ]);

            session()->flash('successData', [
                'serial_number' => $this->serialNumber,
                'category' => $this->category,
                'vendor' => $this->vendor,
                'condition' => $this->condition,
                'status' => $this->status,
                'location' => $this->location,
                'description' => $this->description,
                'link_qr' => "https://api.qrserver.com/v1/create-qr-code/?data={$this->serialNumber}"
            ]);

            $this->reset(['serialNumber', 'category', 'vendor', 'condition', 'status', 'location', 'description']);
        } catch (\Exception $e) {
            session()->flash('error', 'Serial number đã tồn tại hoặc xảy ra lỗi: ' . $e->getMessage());
        }
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
}
