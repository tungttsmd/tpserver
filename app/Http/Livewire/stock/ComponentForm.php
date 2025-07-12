<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Component as HardwareComponent;
use App\Models\Condition;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Vendor;
use Carbon\Carbon;

class ComponentForm extends Component
{
    use WithPagination;
    public $date_created, $serial_number, $category_id, $vendor_id, $location_id, $condition_id, $manufacturer_id, $status_id, $name, $date_issued, $warranty_start, $warranty_end, $note;
    public $view_form_content = '';
    public $serialNumber = null;
    public $previous_view = null;
    protected $listeners = ['scanRequest' => 'scanResponse', 'setScanModeRequest' => 'setScanModeResponse', 'formCreateRequest' => 'formCreateResponse'];
    public $mode = 'manual';
    public $createSuccess = null;

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
        // Lưu lại vào session
        return view('livewire.component-form', $handler);
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
        $manufacturers = Manufacturer::select('id', 'name')
            ->get();
        return ['categories' => $categories, 'conditions' => $conditions, 'vendors' => $vendors, 'locations' => $locations, 'manufacturers' => $manufacturers];
    }
    public function rules()
    {
        return [
            'serial_number' => 'required|string|max:255|unique:components,serial_number',
            'name' => 'nullable|string|max:255|unique:components,name',
            'category_id' => 'required|exists:categories,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'location_id' => 'nullable|exists:locations,id',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            // 'status_id' => 'nullable|exists:statuses,id',
            'note' => 'nullable|string|max:10000',

            // NGÀY hợp lệ: tránh lỗi 1111-11-11
            'warranty_start' => 'nullable|date|after_or_equal:1970-01-01',
            'warranty_end' => 'nullable|date|after_or_equal:warranty_start',
        ];
    }

    public function formCreateSubmit()
    {
        $this->validate();

        if ($this->warranty_start && strtotime($this->warranty_start) < strtotime('01/01/1970')) {
            $this->addError('warranty_start', 'Ngày bảo hành phải sau 01/01/1970.');
            return;
        }
        if ($this->warranty_end && strtotime($this->warranty_end) < strtotime('01/01/1970')) {
            $this->addError('warranty_end', 'Ngày bảo hành phải sau 01/01/1970.');
            return;
        }

        $qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$this->serial_number}&size=240x240";

        $insert = [
            'serial_number' => $this->serial_number,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'condition_id' => $this->condition_id,
            'location_id' => $this->location_id,
            'vendor_id' => $this->vendor_id,
            'manufacturer_id' => $this->manufacturer_id,
            'status_id' => 1,
            'note' => $this->note,
            'warranty_start' => $this->isValidMysqlTimestamp($this->warranty_start) ? $this->warranty_start : null,
            'warranty_end' => $this->isValidMysqlTimestamp($this->warranty_end) ? $this->warranty_end : null,
            'date_created' => $this->date_created ?? now(),
        ];

        // Thêm mới dữ liệu
        $component = HardwareComponent::create($insert);

        // Load quan hệ từ dữ liệu vừa thêm mới
        $component->load(['category', 'condition', 'location', 'vendor', 'manufacturer']);

        // Truy xuất tên từ quan hệ
        $this->createSuccess = [
            'serial_number' => $component->serial_number ?? null,
            'name' => $component->name ?? null,
            'category' => $component->category->name,
            'condition' => $component->condition->name ?? null,
            'location' => $component->location->name ?? null,
            'vendor' => $component->vendor->name ?? null,
            'manufacturer' => $component->manufacturer->name ?? null,
            'note' => $component->note ?? null,
            'warranty_start' => $component->warranty_start ?? null,
            'warranty_end' => $component->warranty_end ?? null,
            'date_created' => $component->date_created ?? null,
            'qrcode' => $qrcode ?? null,
        ];

        $this->resetExcept('serialNumber', 'view_form_content', 'createSuccess', 'historyViewList');
        $this->setDefaultDates(); // ← set lại mặc định cho các field ngày
    }

    public function isValidMysqlTimestamp($date)
    {
        if (!$date)
            return false;
        try {
            $ts = strtotime($date);
            return $ts !== false && $ts >= 0 && $ts <= 2147483647;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function setDefaultDates()
    {
        $today = now()->format('Y-m-d H:i:s');
        $this->date_created = $this->date_created ?? $today;
        $this->warranty_start = $this->warranty_start ?? $today;
        $this->warranty_end = $this->warranty_end ?? $today;
    }

    public function backward()
    {
        // $previousView = session()->get('historyViewList');
        // dd($previousView);
    }
    public function mount($form)
    {
        // Giá trị mặc định cho form 'Y-m-d' là định dạng dùng cho truyền đúng dữ liệu type date
        if (!$this->date_created) {
            $this->date_created = Carbon::now()->format('Y-m-d');
        }
        if (!$this->warranty_start) {
            $this->warranty_start = Carbon::now()->format('Y-m-d');
        }
        if (!$this->warranty_end) {
            $this->warranty_end = Carbon::now()->format('Y-m-d');
        }

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
