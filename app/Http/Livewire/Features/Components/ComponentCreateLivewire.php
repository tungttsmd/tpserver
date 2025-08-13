<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Category;
use App\Models\Component as HardwareComponent;
use App\Models\ComponentLog;
use App\Models\Condition;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ComponentCreateLivewire extends Component
{
    protected $listeners = ['routeRefreshCall' => '$refresh', 'createSubmit' => 'createSubmit', 'toggleWarranty' => 'toggleWarranty'];

    public $stockin_at, $serial_number, $category_id, $vendor_id, $location_id, $condition_id, $manufacturer_id, $status_id, $name, $date_issued, $warranty_start, $warranty_end, $note;
    public $serialNumber = null;
    public $createSuccess = null;
    public $toggleWarranty = null;


    public function mount()
    {
        $this->setDefaultDate();
    }
    public function setDefaultDate($warranty = null)
    {
        $today = Carbon::now()->format('Y-m-d');

        $this->stockin_at = $today;

        if ($warranty === true) {
            $this->warranty_start = $today;
            $this->warranty_end = $today;
        } else {
            $this->warranty_start = null;
            $this->warranty_end = null;
        }
    }
    public function toggleWarranty($value = null)
    {
        $this->setDefaultDate($value);
        $this->toggleWarranty = $value;
    }
    public function getRelationData()
    {
        return [
            'categories' => Category::select('id', 'name')->get(),
            'conditions' => Condition::select('id', 'name')->get(),
            'locations' => Location::select('id', 'name')->get(),
            'vendors' => Vendor::select('id', 'name')->get(),
            'manufacturers' => Manufacturer::select('id', 'name')->get(),
        ];
    }
    public function render()
    {
        $data = $this->getRelationData();
        return view('livewire.features.components.create', $data);
    }

    public function createSubmit()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            // Lấy lỗi validation dưới dạng array (key => [message,...])
            $errors = $e->validator->errors()->toArray();

            // Có thể convert thành chuỗi gộp message để dễ show alert
            $messages = collect($errors)->flatten()->implode(' ');

            $this->dispatchBrowserEvent('danger-alert', [
                'message' => 'Dữ liệu không hợp lệ, vui lòng kiểm tra lại!',
                'errors' => $errors,
                'messages' => $messages,
            ]);

            return; // dừng hàm update
        }

        // Kiểm tra ngày bảo hành hợp lệ
        if ($this->warranty_start && strtotime($this->warranty_start) < strtotime('1970-01-01')) {
            $this->dispatchBrowserEvent('danger-alert', ['message' => 'Ngày bảo hành phải sau 01/01/1970.']);
            return;
        }
        if ($this->warranty_end && strtotime($this->warranty_end) < strtotime('1970-01-01')) {
            $this->dispatchBrowserEvent('danger-alert', ['message' => 'Ngày bảo hành phải sau 01/01/1970.']);
            return;
        }

        $qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$this->serial_number}&size=240x240";
        $barcode = "https://bwipjs-api.metafloor.com/?bcid=code128&text={$this->serial_number}&scale=3&width=64&height=8&includetext&textxalign=center&background=ffffff";

        $insert = [
            'serial_number' => $this->serial_number,
            'name' => $this->name,
            'stockin_at' => $this->stockin_at,
            'category_id' => $this->category_id ?? null,
            'condition_id' => $this->condition_id ?? null,
            'location_id' => $this->location_id ?? null,
            'vendor_id' => $this->vendor_id ?? null,
            'manufacturer_id' => $this->manufacturer_id ?? null,
            'status_id' => 1, // Mặc định thêm mới là Đang tồn kho
            'note' => $this->note ?? null,
            'warranty_start' => $this->isValidMysqlTimestamp($this->warranty_start) ? $this->warranty_start : null,
            'warranty_end' => $this->isValidMysqlTimestamp($this->warranty_end) ? $this->warranty_end : null,
        ];

        $component = HardwareComponent::create($insert);
        $component->load(['category', 'condition', 'location', 'vendor', 'manufacturer']);

        $this->createSuccess = [
            'serial_number' => $component->serial_number,
            'name' => $component->name,
            'stockin_at' => $component->stockin_at,
            'category' => $component->category->name ?? null,
            'condition' => $component->condition->name ?? null,
            'location' => $component->location->name ?? null,
            'vendor' => $component->vendor->name ?? null,
            'manufacturer' => $component->manufacturer->name ?? null,
            'note' => $component->note ?? null,
            'warranty_start' => $component->warranty_start ?? null,
            'warranty_end' => $component->warranty_end ?? null,
            'qrcode' => $qrcode ?? null,
            'barcode' => $barcode ?? null,
        ];

        ComponentLog::create([
            'component_id' => $component->id,
            'user_id' => auth()->user()->id,
            'action_id' => 15, // Dữ liệu nhập kho, thêm mơi
            'location_id' => $this->location_id ?? null,
            'customer_id' => null,
            'vendor_id' => $this->vendor_id ?? null,
            'note' => 'Nhập kho linh kiện mới',
            'stockout_at' => null, // fallback nếu null
            'stockreturn_at' => null, // fallback nếu null
        ]);

        $this->dispatchBrowserEvent('success-alert', [
            'message' => 'Thêm mới thành công!',
        ]);
        $this->resetExcept('serialNumber', 'view_form_content', 'createSuccess', 'historyViewList');
        $this->setDefaultDate();
    }
    public function rules()
    {
        return [
            'serial_number' => 'required|string|max:255|unique:components,serial_number',
            'name' => 'required|string|max:255|unique:components,name',
            'stockin_at' => 'date|after_or_equal:1970-01-01',


            'category_id' => 'nullable|exists:categories,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'location_id' => 'nullable|exists:locations,id',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',

            'note' => 'nullable|string|max:10000',
            'warranty_start' => 'nullable|date|after_or_equal:1970-01-01',
            'warranty_end' => 'nullable|date|after_or_equal:warranty_start',
        ];
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
}
