<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Action;
use App\Models\Component as ModelsComponent;
use App\Models\Customer;
use App\Models\Location;
use App\Models\LogComponent;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class ComponentStockoutLivewire extends Component
{
    use WithPagination;

    // Component State
    public $componentId, $component;

    // Form Properties
    public $stockoutType = 'internal';
    public $action_id = '33'; // Default to 'Xuất kho nội bộ'
    public $stockout_at;
    public $customer_id, $vendor_id, $location_id;
    public $note;

    // Options for Selects
    public $actionStockoutCustomer, $actionStockoutVendor, $actionStockoutInternal;
    public $vendorOptions, $customerOptions, $locationOptions;

    protected $listeners = ['record' => 'record', 'routeRefreshCall' => '$refresh'];

    public function mount()
    {
        $this->stockout_at = Carbon::now()->toDateString();

        // Load options for select dropdowns
        $this->actionStockoutCustomer = Action::where('target', 'componentStockoutCustomer')->get();
        $this->actionStockoutVendor = Action::where('target', 'componentStockoutVendor')->get();
        $this->actionStockoutInternal = Action::where('target', 'componentStockoutInternal')->get();

        $this->vendorOptions = Vendor::select('id', 'name', 'phone', 'email')->orderBy('id', 'asc')->get();
        $this->customerOptions = Customer::select('id', 'name', 'phone', 'email')->orderBy('id', 'asc')->get();
        $this->locationOptions = Location::select('id', 'name')->orderBy('id', 'asc')->get();

        // Set default select values
        if ($this->locationOptions->isNotEmpty()) {
            $this->location_id = $this->locationOptions->first()->id;
        }
        if ($this->vendorOptions->isNotEmpty()) {
            $this->vendor_id = $this->vendorOptions->first()->id;
        }
        if ($this->customerOptions->isNotEmpty()) {
            $this->customer_id = $this->customerOptions->first()->id;
        }
    }

    public function render()
    {
        $this->loadComponent();
        return view('livewire.features.items.stockout');
    }

    public function stockout()
    {
        try {
            $this->validate([
                'location_id' => 'nullable|exists:locations,id',
                'vendor_id' => 'nullable|exists:vendors,id',
                'customer_id' => 'nullable|exists:customers,id',
                'note' => 'nullable|string|max:10000',
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            $messages = collect($errors)->flatten()->implode(' ');

            $this->dispatchBrowserEvent('danger-alert', [
                'message' => 'Dữ liệu không hợp lệ, vui lòng kiểm tra lại!',
                'errors' => $errors,
                'messages' => $messages,
            ]);

            return;
        }

        $user = auth()->user();
        $customerId = null;
        $vendorId = null;
        $locationId = null;

        switch ($this->stockoutType) {
            case 'customer':
                $customerId = $this->customer_id;
                break;
            case 'vendor':
                $vendorId = $this->vendor_id;
                break;
            case 'internal':
                $locationId = $this->location_id;
                break;
        }

        try {
            LogComponent::create([
                'component_id' => $this->componentId,
                'user_id' => $user->id,
                'action_id' => $this->action_id,
                'location_id' => $locationId,
                'customer_id' => $customerId,
                'vendor_id' => $vendorId,
                'note' => $this->note,
                'stockout_at' => Carbon::parse($this->stockout_at ?? now()),
                'stockreturn_at' => null,
            ]);

            $this->component->update(['status_id' => 2]);

            $message = 'Đã xuất kho linh kiện ' . $this->component->name . ' (' . $this->component->serial_number . ') thành công.';
            $this->dispatchBrowserEvent('success-alert', ['message' => $message]);

        } catch (\Throwable $e) {
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

        $this->dispatchBrowserEvent('closePopup');
        $this->reset('note');
        $this->emit('routeRefreshCall');
    }

    public function setStockoutType($stockoutType)
    {
        $this->stockoutType = $stockoutType;

        if ($this->stockoutType === 'customer' && $this->actionStockoutCustomer->isNotEmpty()) {
            $this->action_id = $this->actionStockoutCustomer->first()->id;
        } elseif ($this->stockoutType === 'vendor' && $this->actionStockoutVendor->isNotEmpty()) {
            $this->action_id = $this->actionStockoutVendor->first()->id;
        } elseif ($this->stockoutType === 'internal' && $this->actionStockoutInternal->isNotEmpty()) {
            $this->action_id = $this->actionStockoutInternal->first()->id;
        }
    }

    public function record($id)
    {
        $this->componentId = $id;
        $this->loadComponent();
    }

    private function loadComponent()
    {
        if ($this->componentId) {
            $this->component = ModelsComponent::with(['category', 'status'])->find($this->componentId);

            if (!$this->component) {
                $this->dispatchBrowserEvent('danger-alert', ['message' => 'Component not found!']);
                $this->componentId = null; // Reset ID if not found
            }
        }
    }
}
