<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\ActionLog;
use App\Models\Component as ModelsComponent;
use App\Models\ComponentLog;
use App\Models\Customer;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ComponentStockoutLivewire extends Component
{
    public $componentId, $component;
    public $qrcode;
    public $action_id, $stockout_at, $customer_id, $vendor_id, $note;
    protected $actions, $customers, $vendors;
    public $stockoutType = null;

    public function render()
    {
        $data = $this->getRelationshipData();
        return view('livewire.features.components.stockout', $data);
    }
    public function mount()
    {
        $this->actions = ActionLog::where('target', 'componentStockoutInternal')->get();
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
    public function stockout(User $user)
    {
        try {
            $this->validate([
                'vendor_id' => 'nullable|required|exists:vendors,id',
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

        if ($this->stockoutType === 'customer') {

        } elseif ($this->stockoutType === 'vendor') {

        } else {
            $action_id = 18;
        }

        ComponentLog::create([
            'component_id' => $this->componentId,
            'user_id' => $user->id, // Nếu đang dùng auth
            'action_id' => $action_id, // 18 là mã "Xuất kho" trong action logs
            'customer_id' => $this->customer_id ?? null, // Nếu có thông tin customer thì truyền vào
            'vendor_id' => $this->vendor_id ?? null,
            'note' => $this->note,
            'stockout_at' => Carbon::parse($this->stockout_at),
        ]);

        // 'note' => "Người dùng $user->alias ($user->username) đã xuất kho linh kiện",

        $this->dispatchBrowserEvent('success-alert', [
            'message' => "Đã xuất kho linh kiện " . $this->component->name . " (" . $this->component->serial_number . ") thành công.",
        ]);
    }
    public function getRelationshipData()
    {
        return [
            'actions' => $this->actions,
            'customers' => Customer::all(),
            'vendors' => Vendor::all()
        ];
    }
    public function setStockoutType($type)
    {
        $this->stockoutType = $type;

        if ($type === 'customer') {
            $this->actions = ActionLog::where('target', 'componentStockoutCustomer')->get();
            $this->vendor_id = null;
        } elseif ($type === 'vendor') {
            $this->actions = ActionLog::where('target', 'componentStockoutVendor')->get();
            $this->customer_id = null;
        } else {
            $this->actions = ActionLog::where('target', 'componentStockoutInternal')->get();
            $this->vendor_id = null;
            $this->customer_id = null;
        }
    }
}
