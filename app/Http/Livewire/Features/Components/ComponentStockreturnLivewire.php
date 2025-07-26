<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Component as ModelsComponent;
use Livewire\Component;
use App\Models\Vendor;
use App\Models\Location;
use App\Models\Customer;
use App\Models\ActionLog;
use App\Models\ComponentLog;
use Carbon\Carbon;

class ComponentStockreturnLivewire extends Component
{
    public $componentId, $component, $qrcode, $stockoutType, $stockout_at, $action_id, $customer_id, $vendor_id, $location_id;
    public $actionStockoutVendor, $actionStockoutInternal, $actionStockoutCustomer;
    public $vendorOptions, $customerOptions, $locationOptions;
    public $componentLogs;
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
        ]);
        return view('livewire.features.components.stockreturn', $data);
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

        if (!$this->stockout_at) {
            $this->stockout_at = Carbon::now()->toDateString(); // == format('Y-m-d') Ngày xuất kho mặc định là hôm nay
        } else {
            $this->stockout_at = Carbon::parse($this->stockout_at ?? now());
        }

        $this->component = ModelsComponent::find($this->componentId);
        $this->componentLogs = ComponentLog::where('component_id', $this->componentId);

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
}
