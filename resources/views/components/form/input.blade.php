@props([
    'type' => 'text',
    'name' => '',
    'label' => '',
    'placeholder' => '',
    'required' => false,
    'icon' => '',
    'options' => [],
    'wireModel' => '',
    'value' => ''
])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    
    <div class="input-group">
        @if($icon)
            <span class="input-group-text">
                <i class="{{ $icon }}"></i>
            </span>
        @endif
        
        @if($type === 'select')
            <select 
                class="form-select" 
                id="{{ $name }}"
                name="{{ $name }}"
                @if($wireModel) wire:model.defer="{{ $wireModel }}" @endif
                @if($required) required @endif
            >
                <option value="">-- Chọn {{ strtolower($label) }} --</option>
                @foreach ($options as $key => $option)
                    <option value="{{ $key }}" @if($value == $key) selected @endif>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        @elseif($type === 'textarea')
            <textarea 
                class="form-control" 
                id="{{ $name }}"
                name="{{ $name }}"
                @if($wireModel) wire:model.defer="{{ $wireModel }}" @endif
                @if($required) required @endif
                rows="3"
                placeholder="{{ $placeholder }}"
            >{{ $value }}</textarea>
        @else
            <input 
                type="{{ $type }}" 
                class="form-control" 
                id="{{ $name }}"
                name="{{ $name }}"
                @if($wireModel) wire:model.defer="{{ $wireModel }}" @endif
                @if($required) required @endif
                placeholder="{{ $placeholder }}"
                value="{{ $value }}"
            >
        @endif
    </div>
</div>
