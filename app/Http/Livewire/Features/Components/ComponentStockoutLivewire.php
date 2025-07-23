<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\ActionLog;
use App\Models\Component as ModelsComponent;
use App\Models\ComponentLog;
use App\Models\Customer;
use App\Models\Location;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ComponentStockoutLivewire extends Component
{
    public $componentId, $component;
    public $qrcode, $stockoutType, $actionDefault, $actionDefaultId;
    public $action_id, $stockout_at, $customer_id, $vendor_id, $location_id, $note, $none;
    protected $actions, $customers = [], $vendors = [], $locations = [];
    public $actionsStockoutCustomer, $actionsStockoutVendor, $actionsStockoutInternal;
    public $vendorOptions, $customerOptions, $locationOptions;
    public $actionSuggestion = [];

    public function render()
    {
        $this->actionsStockoutCustomer = ActionLog::where('target', 'componentStockoutCustomer')->get();
        $this->actionsStockoutVendor = ActionLog::where('target', 'componentStockoutVendor')->get();
        $this->actionsStockoutInternal = ActionLog::where('target', 'componentStockoutInternal')->get();
        $this->vendorOptions = Vendor::select('id', 'name', 'phone', 'email')->get();
        $this->customerOptions = Customer::select('id', 'name', 'phone', 'email')->get();
        $this->locationOptions = Location::select('id', 'name')->get();

        $data = array_merge(
            $this->getRelationshipData(),
            [
                'actions' => $this->actions,
                'actionStockoutCustomer' => $this->actionsStockoutCustomer,
                'actionStockoutVendor' => $this->actionsStockoutVendor,
                'actionStockoutInternal' => $this->actionsStockoutInternal,
                'vendorOptions' => $this->vendorOptions,
                'customerOptions' => $this->customerOptions,
                'locationOptions' => $this->locationOptions,
            ]
        );
        return view('livewire.features.components.stockout', $data);
    }
    public function mount()
    {
        $this->stockoutType = 'internal';

        $this->actionsStockoutCustomer = ActionLog::where('target', 'componentStockoutCustomer')->get();
        $this->actionsStockoutVendor = ActionLog::where('target', 'componentStockoutVendor')->get();
        $this->actionsStockoutInternal = ActionLog::where('target', 'componentStockoutInternal')->get();

        $this->location_id = $this->location_id ?? null; // Nhập nếu bán hàng
        $this->customer_id = $this->customer_id ?? null; // Nhập nếu bán hàng
        $this->vendor_id = $this->vendor_id ?? null; // Nhập nếu trả hàng
        $this->stockout_at = Carbon::now()->format('Y-m-d');

        $this->component = ModelsComponent::with([
            'category',
            'vendor',
            'condition',
            'location',
            'manufacturer',
            'status'
        ])->where('id', $this->componentId)->first();

        $this->qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$this->component->serial_number}&size=240x240";
    }
    public function stockout()
    {
        try {
            $this->validate([
                'location_id' => 'nullable|exists:locations,id',
                'vendor_id' => 'nullable|exists:vendors,id',
                'customer_id' => 'nullable|exists:customers,id',
                'note' => 'required|string|min:5',
            ]);
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

        $user = auth()->user();

        // Xác định thông tin liên quan tùy theo loại xuất kho
        $locationId = null;
        $customerId = null;
        $vendorId = null;

        switch ($this->stockoutType) {
            case 'customer':
                $customerId = $this->customer_id;
                break;
            case 'vendor':
                $vendorId = $this->vendor_id;
                break;
            case 'internal':
            default:
                $locationId = $this->location_id;
                break;
        }

        // Tạo log xuất kho
        ComponentLog::create([
            'component_id' => $this->componentId,
            'user_id' => $user->id,
            'action_id' => $this->action_id,
            'location_id' => $locationId,
            'customer_id' => $customerId,
            'vendor_id' => $vendorId,
            'note' => $this->note,
            'stockout_at' => Carbon::parse($this->stockout_at ?? now()), // fallback nếu null
        ]);


        // 'note' => "Người dùng $user->alias ($user->username) đã xuất kho linh kiện",

        $this->dispatchBrowserEvent('success-alert', [
            'message' => "Đã xuất kho linh kiện " . $this->component->name . " (" . $this->component->serial_number . ") thành công.",
        ]);
    }
    public function getRelationshipData()
    {
        return [
            'locations' => Location::all(),
            'customers' => Customer::all(),
            'vendors' => Vendor::all()
        ];
    }
    public function setStockoutType($stockoutType)
    {
        $this->stockoutType = $stockoutType;
    }
}
