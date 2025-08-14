<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Category;
use App\Models\Component as ModelsComponent;
use App\Models\Condition;
use App\Models\Manufacturer;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ComponentEditLivewire extends Component
{
    public $component;
    public $componentId = null;
    public $name;
    public $warranty_start, $warranty_end, $note, $manufacturer_id, $stockin_source, $stockin_at, $category_id, $condition_id;
    public $toggleWarranty = false;
    protected $listeners = ['record' => 'record'];

    public function mount()
    {
        $this->mountInit();
    }
    public function mountInit()
    {
        $component = ModelsComponent::findOrFail($this->componentId);

        // Gán vào từng property để bind với form
        $this->component = $component ?? null;
        $this->name = $component->name ?? null;
        $this->category_id = $component->category_id ?? null;
        $this->condition_id = $component->condition_id ?? null;
        $this->stockin_source = $component->stockin_source ?? null;
        $this->manufacturer_id = $component->manufacturer_id ?? null;
        $this->note = $component->note ?? null;

        // format date của laravel không hỗ trợ cho string datetime, phải dùng Carbon (date phải đúng định dạng string trong input form)
        $this->stockin_at = $component->stockin_at ? Carbon::parse($component->stockin_at)->format('Y-m-d') : null;
        $this->warranty_start = $component->warranty_start ? Carbon::parse($component->warranty_start)->format('Y-m-d') : null;
        $this->warranty_end = $component->warranty_end ? Carbon::parse($component->warranty_end)->format('Y-m-d') : null;

        $this->toggleWarranty = !is_null($component->warranty_start);
    }
    public function render()
    {
        $this->mountInit();
        $data = array_merge($this->getRelationData(), ['component' => $this->component]);
        return view('livewire.features.components.edit', $data);
    }

    public function getRelationData()
    {
        return [
            'categories' => Category::select('id', 'name')->get(),
            'conditions' => Condition::select('id', 'name')->get(),
            'manufacturers' => Manufacturer::select('id', 'name')->get(),
        ];
    }
    public function update()
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

        $component = ModelsComponent::findOrFail($this->componentId);

        // ==== KHU VỰC UPDATE trường date, nơi luôn bị dirty nếu dùng Carbon kể cả k cập nhật ====

        // Chuẩn hóa giá trị ngày sang định dạng Y-m-d để so sánh
        $oldStockinAt = null;
        if ($component->stockin_at) {
            $oldStockinAt = $component->stockin_at instanceof Carbon
                ? $component->stockin_at->format('Y-m-d')
                : Carbon::parse($component->stockin_at)->format('Y-m-d');
        }

        $oldWarrantyStart = null;
        if ($component->warranty_start) {
            $oldWarrantyStart = $component->warranty_start instanceof Carbon
                ? $component->warranty_start->format('Y-m-d')
                : Carbon::parse($component->warranty_start)->format('Y-m-d');
        }

        $oldWarrantyEnd = null;
        if ($component->warranty_end) {
            $oldWarrantyEnd = $component->warranty_end instanceof Carbon
                ? $component->warranty_end->format('Y-m-d')
                : Carbon::parse($component->warranty_end)->format('Y-m-d');
        }

        $newStockinAt = $this->stockin_at;
        $newWarrantyStart = $this->toggleWarranty ? $this->warranty_start : null;
        $newWarrantyEnd = $this->toggleWarranty ? $this->warranty_end : null;

        // Chỉ gán lại các trường date khi khác nhau
        if ($oldStockinAt !== $newStockinAt) {
            $component->stockin_at = $newStockinAt ? Carbon::parse($newStockinAt) : null;
        }
        if ($oldWarrantyStart !== $newWarrantyStart) {
            $component->warranty_start = $newWarrantyStart ? Carbon::parse($newWarrantyStart) : null;
        }
        if ($oldWarrantyEnd !== $newWarrantyEnd) {
            $component->warranty_end = $newWarrantyEnd ? Carbon::parse($newWarrantyEnd) : null;
        }

        // ==== KHU VỰC UPDATE các trường khác ====

        // Ép kiểu int để đảm bảo so sánh đúng kiểu
        $component->name = $this->name;
        $component->category_id = (int) $this->category_id;
        $component->condition_id = (int) $this->condition_id;
        $component->manufacturer_id = (int) $this->manufacturer_id;
        $component->note = $this->note;
        $component->stockin_source = $this->stockin_source;

        // Kiểm tra dirty
        if ($component->isDirty()) {
            $component->save();
            $this->dispatchBrowserEvent('success-alert', ['message' => 'Cập nhật thành công!']);
        } else {
            $this->dispatchBrowserEvent('warning-alert', ['message' => 'Không có thay đổi để cập nhật.']);
        }
    }
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:components,name,' . $this->componentId,
            'stockin_at' => 'date|after_or_equal:1970-01-01',

            'category_id' => 'nullable|integer|exists:categories,id',
            'stockin_source' => 'nullable|string|max:255',
            'condition_id' => 'nullable|integer|exists:conditions,id',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',

            'note' => 'nullable|string|max:10000',
            'warranty_start' => 'nullable|date|after_or_equal:1970-01-01',
            'warranty_end' => 'nullable|date|after_or_equal:warranty_start',
        ];
    }
    public function record($id)
    {
        $this->componentId = $id;
    }
}
