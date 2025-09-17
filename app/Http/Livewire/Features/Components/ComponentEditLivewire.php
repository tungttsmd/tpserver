<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Category;
use App\Models\Component as ModelsComponent;
use App\Models\LogUserAction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ComponentEditLivewire extends Component
{
    // Properties for the component model instance
    public $component;
    public $componentId = null;

    // Form-bound properties
    public $name, $serial_number;
    public $stockin_at, $stockin_source, $category_id;
    public $warranty_start, $warranty_end, $note;
    public $toggleWarranty = false;

    // Event listeners
    protected $listeners = ['record' => 'record'];

    public function mount()
    {
        $this->formRebinding();
    }

    public function formRebinding()
    {
        $this->component = ModelsComponent::findOrFail($this->componentId);

        // Bind model properties to the form
        $this->name = $this->component->name ?? null;
        $this->serial_number = $this->component->serial_number ?? null;
        $this->category_id = $this->component->category_id ?? null;
        $this->stockin_source = $this->component->stockin_source ?? null;
        $this->note = $this->component->note ?? null;

        // Format dates for form inputs
        $this->stockin_at = $this->component->stockin_at ? Carbon::parse($this->component->stockin_at)->format('Y-m-d') : null;
        $this->warranty_start = $this->component->warranty_start ? Carbon::parse($this->component->warranty_start)->format('Y-m-d') : null;
        $this->warranty_end = $this->component->warranty_end ? Carbon::parse($this->component->warranty_end)->format('Y-m-d') : null;

        $this->toggleWarranty = !is_null($this->component->warranty_start);
    }

    public function render()
    {
        $data = array_merge($this->getRelationData(), ['component' => $this->component]);
        return view('livewire.features.items.edit', $data);
    }

    public function getRelationData()
    {
        return [
            'categories' => Category::select('id', 'name')->get(),
        ];
    }

    public function update()
    {
        $this->validateData();

        // Tìm component + load quan hệ
        $component = ModelsComponent::with(['category'])->findOrFail($this->componentId);

        // Ghi log người dùng
        $this->logUserAction($component);

        // Lưu model và thông báo
        $this->saveAndNotify($component);
    }

    /**
     * Validation rules for the form fields.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:components,name,' . $this->componentId,
            'stockin_at' => 'date|after_or_equal:1970-01-01',
            'category_id' => 'nullable|integer|exists:categories,id',
            'stockin_source' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:10000',
            'warranty_start' => 'nullable|date|after_or_equal:1970-01-01',
            'warranty_end' => 'nullable|date|after_or_equal:warranty_start',
        ];
    }

    public function record($id)
    {
        $this->componentId = $id;
        $this->formRebinding();
    }

    /**
     * Validates the form data and dispatches an event on failure.
     */
    private function validateData()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            $messages = collect($errors)->flatten()->implode(' ');

            $this->dispatchBrowserEvent('danger-alert', [
                'message' => 'Dữ liệu không hợp lệ, vui lòng kiểm tra lại!',
                'errors' => $errors,
                'messages' => $messages,
            ]);

            // Stop execution if validation fails
            throw $e;
        }
    }

    /**
     * Updates the date fields of the component model, avoiding unnecessary dirty states.
     *
     * @param \App\Models\Component $component
     */
    private function updateDateFields(ModelsComponent $component)
    {
        $dateFields = [
            'stockin_at' => $this->stockin_at,
            'warranty_start' => $this->toggleWarranty ? $this->warranty_start : null,
            'warranty_end' => $this->toggleWarranty ? $this->warranty_end : null,
        ];

        foreach ($dateFields as $field => $newValue) {
            $oldValue = $component->$field ? Carbon::parse($component->$field)->format('Y-m-d') : null;
            if ($oldValue !== $newValue) {
                $component->$field = $newValue ? Carbon::parse($newValue) : null;
            }
        }
    }

    /**
     * Updates the general fields of the component model.
     *
     * @param \App\Models\Component $component
     */
    private function updateGeneralFields(ModelsComponent $component)
    {
        $component->name = $this->name;
        $component->category_id = (int) $this->category_id;
        $component->note = $this->note;
        $component->stockin_source = $this->stockin_source;
    }

    /**
     * Saves the component if it has changes and dispatches a browser event.
     *
     * @param \App\Models\Component $component
     */
    private function saveAndNotify(ModelsComponent $component)
    {
        if ($component->isDirty()) {
            $component->save();
            $this->dispatchBrowserEvent('success-alert', ['message' => 'Cập nhật thành công!']);
        } else {
            $this->dispatchBrowserEvent('warning-alert', ['message' => 'Không có thay đổi để cập nhật.']);
        }
    }

    private function logUserAction($component)
    {
        // Gán giá trị mới
        $this->updateDateFields($component);
        $this->updateGeneralFields($component);

        // Lấy các thay đổi (dirty fields)
        $dirty    = $component->getDirty();
        $original = $component->getOriginal();

        // Ghi log chi tiết từng trường
        foreach ($dirty as $field => $newValue) {
            $oldValue = $original[$field] ?? null;

            // Nếu cần ghi kèm tên quan hệ, ví dụ category
            if ($field === 'category_id') {
                $oldValue = optional($component->getRelationValue('category')->find($oldValue))->name ?? $oldValue;
                $newValue = optional($component->category)->name ?? $newValue;
            }

            LogUserAction::create([
                'user_id'      => Auth::id(),
                'action_id'    => 1,
                'component_id' => $this->componentId,
                'note'         => Auth::user()->alias .
                    " tại linh kiện {$component->name} (#{$component->id}) đã thay đổi trường **{$field}** từ '{$oldValue}' thành '{$newValue}'",
            ]);
        }
    }
}
