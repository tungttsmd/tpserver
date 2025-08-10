<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\ActionLog;
use App\Models\Component as ModelsComponent;
use App\Models\ComponentLog;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class ComponentStockoutLivewire extends Component
{
    use WithPagination;
    public $componentId, $component;
    public $qrcode, $stockoutType, $actionDefault, $actionDefaultId;
    public $action_id, $stockout_at, $customer_id, $vendor_id, $location_id, $note, $none;
    protected $actions, $customers = [], $vendors = [], $locations = [];
    public $actionsStockoutCustomer, $actionsStockoutVendor, $actionsStockoutInternal;
    public $vendorOptions, $customerOptions, $locationOptions;
    protected $listeners = ['record' => 'record', 'routeRefreshCall' => '$refresh', 'componentId' => 'setComponentId', 'actionId' => 'setActionId'];
    public $actionSuggestion = [];

    public function render()
    {
        $this->mountInit();

        if ($this->locationOptions->isNotEmpty() && !$this->location_id) {
            $this->location_id = $this->locationOptions->first()->id;
        }
        if ($this->vendorOptions->isNotEmpty() && !$this->vendor_id) {
            $this->vendor_id = $this->vendorOptions->first()->id;
        }
        if ($this->customerOptions->isNotEmpty() && !$this->customer_id) {
            $this->customer_id = $this->customerOptions->first()->id;
        }

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
        $this->mountInit();
    }
    public function mountInit()
    {
        if (!$this->stockoutType) {
            $this->stockoutType = 'internal';
        }
        if (!$this->action_id) {
            $this->action_id = '33'; // Mã xuất kho nội bộ
        }

        if (!$this->stockout_at) { // Ngày xuất kho mặc định là hôm nay
            $this->stockout_at = Carbon::now()->toDateString(); // == format('Y-m-d')
        }
        // Load danh sách hành động theo từng loại
        $this->actionsStockoutCustomer = ActionLog::where('target', 'componentStockoutCustomer')->get();
        $this->actionsStockoutVendor = ActionLog::where('target', 'componentStockoutVendor')->get();
        $this->actionsStockoutInternal = ActionLog::where('target', 'componentStockoutInternal')->get();

        $this->vendorOptions = Vendor::select('id', 'name', 'phone', 'email')->orderBy('id', 'asc')->get();
        $this->customerOptions = Customer::select('id', 'name', 'phone', 'email')->orderBy('id', 'asc')->get();
        $this->locationOptions = Location::select('id', 'name')->orderBy('id', 'asc')->get();

        // Load thông tin linh kiện
        $this->component = ModelsComponent::with([
            'category',
            'vendor',
            'condition',
            'location',
            'manufacturer',
            'status',
        ])->find($this->componentId);

        // Nếu không tìm thấy linh kiện thì nên xử lý fallback
        if (!$this->component) {
            abort(404, 'Không tìm thấy linh kiện!');
        }

        // Tạo đường dẫn QR code
        $this->qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$this->component->serial_number}&size=240x240";
    }

    public function stockout()
    {
        try {
            $this->validate([
                'location_id' => 'nullable|exists:locations,id',
                'vendor_id' => 'nullable|exists:vendors,id',
                'customer_id' => 'nullable|exists:customers,id',
                'note' => 'nullable|string',
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


        switch ($this->stockoutType) {
            case 'customer':
                $customerId = $this->customer_id;
                $vendorId = null;
                $locationId = null;
                break;
            case 'vendor':
                $customerId = null;
                $vendorId = $this->vendor_id;
                $locationId = null;
                break;
            case 'internal':
                $customerId = null;
                $vendorId = null;
                $locationId = $this->location_id;
                break;
        }

        try {
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
                'stockreturn_at' => null, // fallback nếu null
            ]);

            // Cập nhật trạng thái
            $this->component->update([
                'status_id' => 2
            ]);

            // Nội dung thông báo
            $message = "Đã xuất kho linh kiện " . $this->component->name . " (" . $this->component->serial_number . ") thành công.";

            // Thông báo
            $this->dispatchBrowserEvent('success-alert', [
                'message' => $message,
            ]);
        } catch (\Throwable $e) {
            // Ghi log nếu cần
            logger()->error('Stockout failed: ' . $e->getMessage(), [
                'exception' => $e,
                'componentId' => $this->componentId,
            ]);

            $this->dispatchBrowserEvent('danger-alert', [
                'message' => 'Có lỗi xảy ra khi xuất kho. Vui lòng thử lại.',
                'error' => $e->getMessage(),
            ]);

            return;
        }
        // Đóng modal
        $this->dispatchBrowserEvent('closePopup');

        // Reset tất cả trạng thái về giá trị ban đầu
        $this->reset(['note']);
        $this->mountInit();
        $this->emit('routeRefreshCall');
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

        // Gán action_id mặc định theo stockoutType nếu chưa có
        if ($this->stockoutType === 'customer' && $this->actionsStockoutCustomer->isNotEmpty()) {
            $this->action_id = $this->actionsStockoutCustomer->first()->id;
        } elseif ($this->stockoutType === 'vendor' && $this->actionsStockoutVendor->isNotEmpty()) {
            $this->action_id = $this->actionsStockoutVendor->first()->id;
        } elseif ($this->stockoutType === 'internal' && $this->actionsStockoutInternal->isNotEmpty()) {
            $this->action_id = $this->actionsStockoutInternal->first()->id;
        }
    }
    public function record($id)
    {
        $this->componentId = $id;
    }
}
