<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Component as ModelsComponent;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use App\Models\Vendor;
use App\Models\Location;
use App\Models\Customer;
use App\Models\ActionLog;
use App\Models\ComponentLog;
use Carbon\Carbon;

class ComponentStockreturnLivewire extends Component
{
    public $componentId, $component, $qrcode, $stockoutType, $stockout_at, $stockreturn_at, $action_id, $customer_id, $vendor_id, $location_id, $note;
    public $actionStockoutVendor, $actionStockoutInternal, $actionStockoutCustomer;
    public $vendorOptions, $customerOptions, $locationOptions;
    protected $listeners = ['routeRefreshCall' => '$refresh', 'componentId' => 'setComponentId'];
    public $lastestComponentLog;
    protected $componentLogs;
    public $debug;
    public function render()
    {
        $this->mountInit();

        $this->getStockoutType();
        if ($this->locationOptions->isNotEmpty() && !$this->location_id) {
            $this->location_id = $this->locationOptions->first()->id;
        }
        if ($this->vendorOptions->isNotEmpty() && !$this->vendor_id) {
            $this->vendor_id = $this->vendorOptions->first()->id;
        }
        if ($this->customerOptions->isNotEmpty() && !$this->customer_id) {
            $this->customer_id = $this->customerOptions->first()->id;
        }

        $this->lastestComponentLog = ComponentLog::with(['user', 'action', 'location', 'vendor', 'customer', 'component'])
            ->where('component_id', $this->componentId) // hoặc $id nếu trong Controller
            ->latest('created_at')
            ->first();

        $this->debug = [
            'component_id'    => $this->lastestComponentLog->component_id,
            'action_id'       => 39, // Thu hồi
            'location_id'     => $this->lastestComponentLog->location_id,
            'customer_id'     => $this->lastestComponentLog->customer_id,
            'vendor_id'       => $this->lastestComponentLog->vendor_id,
            'note'            => $this->note ?? null,
            'stockout_at'     => optional($this->lastestComponentLog->stockout_at)->format('Y-m-d H:i:s') ?? now()->format('Y-m-d H:i:s'),
            'stockreturn_at'  => Carbon::parse($this->stockreturn_at)->toDateString() ?? now()->format('Y-m-d'),
        ];
        $data = array_merge([
            'component' => $this->component,
            'action_id' => $this->action_id,
            'customer_id' => $this->customer_id,
            'vendor_id' => $this->vendor_id,
            'location_id' => $this->location_id,
            'stockout_at' => $this->stockout_at,
            'actionStockoutCustomer' => $this->actionStockoutCustomer,
            'actionStockoutVendor' => $this->actionStockoutVendor,
            'actionStockoutInternal' => $this->actionStockoutInternal,
            'vendorOptions' => $this->vendorOptions,
            'customerOptions' => $this->customerOptions,
            'locationOptions' => $this->locationOptions,
            'componentLogs' => $this->componentLogs,
            'lastestComponentLog' => $this->lastestComponentLog
        ]);
        return view('livewire.features.components.stockreturn', $data);
    }
    public function mount()
    {
        $this->stockreturn_at = now()->format('Y-m-d');

        $this->mountInit();
    }
    public function mountInit()
    {
        $this->componentLogs = ComponentLog::where('component_id', $this->componentId);

        if (!$this->stockoutType) {
            $this->stockoutType = 'internal';
        }
        if (!$this->action_id) {

            // $this->action_id = '33'; // Mã xuất kho nội bộ
        }

        if (!$this->stockout_at) {
            $this->stockout_at = Carbon::now()->toDateString(); // == format('Y-m-d') Ngày xuất kho mặc định là hôm nay
        } else {
            $this->stockout_at = Carbon::parse($this->stockout_at ?? now())->toDateString();
        }


        $this->component = ModelsComponent::find($this->componentId);


        $this->actionStockoutCustomer = ActionLog::where('target', 'componentStockoutCustomer')->get();
        $this->actionStockoutVendor = ActionLog::where('target', 'componentStockoutVendor')->get();
        $this->actionStockoutInternal = ActionLog::where('target', 'componentStockoutInternal')->get();
        $this->vendorOptions = Vendor::select('id', 'name', 'phone', 'email')->orderBy('id', 'asc')->get();
        $this->customerOptions = Customer::select('id', 'name', 'phone', 'email')->orderBy('id', 'asc')->get();
        $this->locationOptions = Location::select('id', 'name')->orderBy('id', 'asc')->get();

        $this->action_id =  $this->component->action_id;
        $this->customer_id =  $this->component->customer_id;
        $this->vendor_id =  $this->component->vendor_id;
        $this->location_id =  $this->component->location_id;

        $this->qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$this->component->serial_number}&size=240x240";
    }
    public function getStockoutType()
    {
        if ($this->location_id) {
            $this->stockoutType = 'internal';
        } elseif ($this->customer_id) {
            $this->stockoutType = 'customer';
        } elseif ($this->vendor_id) {
            $this->stockoutType = 'vendor';
        }
    }
    public function stockreturn()
    {
        $this->lastestComponentLog = ComponentLog::with(['user', 'action', 'location', 'vendor', 'customer', 'component'])
            ->where('component_id', $this->componentId) // hoặc $id nếu trong Controller
            ->latest('created_at')
            ->first();

        try {
            $this->validateOnly('note');
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

        try {
            // Tạo log xuất kho
            ComponentLog::create([
                'component_id' => $this->lastestComponentLog->component_id,
                'user_id' => $user->id,
                'action_id' => 39, // Mã action thu hồi duy nhất
                'location_id' => $this->lastestComponentLog->location_id,
                'customer_id' => $this->lastestComponentLog->customer_id,
                'vendor_id' => $this->lastestComponentLog->vendor_id,
                'note' => $this->note,
                'stockout_at' => Carbon::parse($this->lastestComponentLog->stockout_at ?? now()), // fallback nếu null
                'stockreturn_at' => Carbon::parse($this->stockreturn_at) ?? null // fallback nếu null
            ]);

            // Cập nhật trạng thái
            $this->component->update([
                'status_id' => 1
            ]);

            // Nội dung thông báo
            $message = "Đã thu hồi linh kiện " . $this->component->name . " (" . $this->component->serial_number . ") thành công.";

            // dd([$this->action_id,$locationId, $this->location_id, $vendorId, $this->vendor_id, $customerId, $this->customer_id, $this->stockoutType]);
            // 'note' => "Người dùng $user->alias ($user->username) đã xuất kho linh kiện",

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
                'message' => 'Có lỗi xảy ra khi thu hồi. Vui lòng thử lại.',
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
    public function rules()
    {
        return [
            'note' => 'nullable|string',
        ];
    }
    public function record($id)
    {
        $this->componentId = $id;
    }
}
