<div class="w-full">
    {{-- {{ dd(get_defined_vars()) }} // Debug LayoutController --}}


    {{-- Phải có wire:key để ép livewire refresh bởi vì mặc định livewire sẽ dựa vào DOM thay đổi (không đúng trong lúc này) --}}
    {{-- extract(session('route') từ RouteController): $controller, $action, $filter --}}

    @php
        $controller = session('route.controller') ?? null;
        $action = session('route.action') ?? null;
        $filter = session('route.filter') ?? null;
        $refresh = $controller . $action . $filter;

    @endphp

    <div class="overflow-auto">
        @if ($controller === 'components')
            @if ($action === 'scan')
                <livewire:features.components.component-scan-livewire wire:key="{{ $refresh }}" />
            @elseif ($action === 'create')
                <livewire:features.components.component-create-livewire wire:key="{{ $refresh }}" />
            @else
                <livewire:features.components.component-index-livewire :filter="$filter"
                    wire:key="{{ $refresh }}" />
            @endif
        @else
            <p>Không tìm thấy</p>
        @endif

        {{-- Nội dung được bọc trong Livewire LayoutController --}}

        {{-- Nội dung sẽ được render ở đây thông qua livewire --}}

    </div>

</div>
