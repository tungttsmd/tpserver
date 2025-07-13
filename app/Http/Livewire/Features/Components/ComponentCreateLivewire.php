<?php

namespace App\Http\Livewire\Features\Components;

use App\Http\Livewire\RouteController;
use App\Models\Category;
use App\Models\Component as HardwareComponent;
use App\Models\Condition;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Vendor;
use Carbon\Carbon;

class ComponentCreateLivewire extends RouteController
{
    public $stockin_at, $serial_number, $category_id, $vendor_id, $location_id, $condition_id, $manufacturer_id, $status_id, $name, $date_issued, $warranty_start, $warranty_end, $note;
    public $serialNumber = null;
    protected $listeners = ['routeRefreshCall' => '$refresh', 'formCreateRequest' => 'formCreateResponse'];
    public $createSuccess = null;

    public function mount()
    {
        logger('Mount ComponentCreateLivewire', ['serial_number' => $this->serial_number]);
        $this->setDefaultDates();
    }

    public function render()
    {
        $data = $this->loadCreateFormData();
        return view('livewire.features.components.create', $data);
    }

    public function formCreateSubmit()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Bạn có thể xử lý lỗi khác hoặc show form error
            dd($e->errors());
        }

        // Kiểm tra ngày bảo hành hợp lệ
        if ($this->warranty_start && strtotime($this->warranty_start) < strtotime('1970-01-01')) {
            $this->addError('warranty_start', 'Ngày bảo hành phải sau 01/01/1970.');
            return;
        }
        if ($this->warranty_end && strtotime($this->warranty_end) < strtotime('1970-01-01')) {
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
            'status_id' => 1, // mặc định mới
            'note' => $this->note,
            'warranty_start' => $this->isValidMysqlTimestamp($this->warranty_start) ? $this->warranty_start : null,
            'warranty_end' => $this->isValidMysqlTimestamp($this->warranty_end) ? $this->warranty_end : null,
            'date_created' => $this->date_issued ?? now(),
            'stockin_at' => $this->stockin_at ?? now()->format('Y-m-d'),
        ];

        $component = HardwareComponent::create($insert);
        $component->load(['category', 'condition', 'location', 'vendor', 'manufacturer']);

        $this->createSuccess = [
            'serial_number' => $component->serial_number,
            'name' => $component->name,
            'category' => $component->category->name ?? null,
            'condition' => $component->condition->name ?? null,
            'location' => $component->location->name ?? null,
            'vendor' => $component->vendor->name ?? null,
            'manufacturer' => $component->manufacturer->name ?? null,
            'note' => $component->note,
            'warranty_start' => $component->warranty_start,
            'warranty_end' => $component->warranty_end,
            'date_created' => $component->date_created,
            'qrcode' => $qrcode,
        ];

        $this->resetExcept('serialNumber', 'view_form_content', 'createSuccess', 'historyViewList');
        $this->setDefaultDates();
    }

    public function loadCreateFormData()
    {
        return [
            'categories' => Category::select('id', 'name')->get(),
            'conditions' => Condition::select('id', 'name')->get(),
            'locations' => Location::select('id', 'name')->get(),
            'vendors' => Vendor::select('id', 'name')->get(),
            'manufacturers' => Manufacturer::select('id', 'name')->get(),
        ];
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
            'note' => 'nullable|string|max:10000',
            'warranty_start' => 'nullable|date|after_or_equal:1970-01-01',
            'warranty_end' => 'nullable|date|after_or_equal:warranty_start',
        ];
    }

    public function isValidMysqlTimestamp($date)
    {
        if (!$date) return false;
        try {
            $ts = strtotime($date);
            return $ts !== false && $ts >= 0 && $ts <= 2147483647;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setDefaultDates()
    {
        $today = now()->format('Y-m-d');

        $this->stockin_at = $this->stockin_at ?? $today;
        $this->serial_number = $this->serial_number ?? '';
        $this->category_id = $this->category_id ?? null;
        $this->vendor_id = $this->vendor_id ?? null;
        $this->location_id = $this->location_id ?? null;
        $this->condition_id = $this->condition_id ?? null;
        $this->manufacturer_id = $this->manufacturer_id ?? null;
        $this->status_id = $this->status_id ?? 1;
        $this->name = $this->name ?? '';
        $this->date_issued = $this->date_issued ?? null;
        $this->warranty_start = $this->warranty_start ?? $today;
        $this->warranty_end = $this->warranty_end ?? $today;
        $this->note = $this->note ?? '';
    }
}
