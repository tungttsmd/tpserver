<div class="w-full">
    {{-- {{ dd(get_defined_vars()) }} // Debug LayoutController --}}


    {{-- Phải có wire:key để ép livewire refresh bởi vì mặc định livewire sẽ dựa vào DOM thay đổi (không đúng trong lúc này) --}}
    {{-- extract(session('route') từ RouteController): $controller, $action, $filter --}}

    @php
        $refresh = $controller . $action . $filter;
    @endphp
    <div class="flex-col flex justify-between grow h-[100vh]">
        @if ($controller === 'components')
            @if ($action === 'scan')
                <livewire:features.components.component-scan-livewire wire:key="{{ $refresh }}" />
            @elseif ($action === 'create')
                <livewire:features.components.component-create-livewire wire:key="{{ $refresh }}" />
            @else
                <livewire:features.components.component-index-livewire :filter="$filter"
                    wire:key="{{ $refresh }}" />
            @endif
        @elseif ($controller === 'logs')
            @if ($action === 'component')
                <livewire:features.logs.component-livewire :filter="$filter" wire:key="{{ $refresh }}" />
            @elseif ($action === 'user-action')
                <livewire:features.logs.user-action-livewire :filter="$filter" wire:key="{{ $refresh }}" />
            @endif
        @elseif ($controller === 'stats')
            @if ($action === 'index')
                <livewire:features.stats.stat-index-livewire wire:key="{{ $refresh }}" />
            @elseif ($action === 'stock-variation')
                <livewire:features.stats.stat-stock-variation-livewire wire:key="{{ $refresh }}" />
            @endif
        @elseif ($controller === 'exports')
            @if ($action === 'index')
                <livewire:features.exports.export-livewire wire:key="{{ $refresh }}" />
            @endif
        @elseif ($controller === 'customers')
            @if ($action === 'index')
                <livewire:features.customers.customer-index-livewire :filter="$filter" wire:key="{{ $refresh }}" />
            @elseif ($action === 'create')
                <livewire:features.customers.customer-create-livewire :filter="$filter"
                    wire:key="{{ $refresh }}" />
            @endif
        @elseif ($controller === 'vendors')
            @if ($action === 'index')
                <livewire:features.vendors.vendor-index-livewire :filter="$filter" wire:key="{{ $refresh }}" />
            @elseif ($action === 'create')
                <livewire:features.vendors.vendor-create-livewire :filter="$filter" wire:key="{{ $refresh }}" />
            @endif
        @elseif ($controller === 'locations')
            @if ($action === 'index')
                <livewire:features.locations.location-index-livewire :filter="$filter"
                    wire:key="{{ $refresh }}" />
            @elseif ($action === 'create')
                <livewire:features.locations.location-create-livewire :filter="$filter"
                    wire:key="{{ $refresh }}" />
            @endif
        @elseif ($controller === 'users')
            @if ($action === 'index')
                <livewire:features.users.user-index-livewire :filter="$filter" wire:key="{{ $refresh }}" />
            @elseif ($action === 'create')
                {{-- <livewire:features.users.user-create-livewire :filter="$filter" wire:key="{{ $refresh }}" /> --}}
            @endif
        @elseif ($controller === 'roles')
            @if ($action === 'index')
                <livewire:features.roles.role-index-livewire :filter="$filter" wire:key="{{ $refresh }}" />
            @elseif ($action === 'create')
                {{-- <livewire:features.users.user-create-livewire :filter="$filter" wire:key="{{ $refresh }}" /> --}}
            @endif
        @else
            <div class="bg-white-100 flex items-center justify-center h-screen p-6 grow rounded">
                <div class="text-main text-center max-w-md">
                    <div class="text-8xl font-bold text-blue-600 mb-4 text-main ">
                        <i class="text-main fas fa-exclamation-triangle"></i> 404
                    </div>
                    <h1 class="text-main text-3xl font-semibold text-gray-800 mb-2">Không tìm thấy trang</h1>
                    <p class="text-gray-600 mb-6">
                        Trang bạn đang tìm có thể đã bị xoá hoặc không còn tồn tại.<br>Vui lòng kiểm tra lại
                        đường dẫn hoặc quay về trang chính.
                    </p>
                    <a href="/"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white bg-main font-semibold px-6 py-3 rounded-xl shadow transition">
                        <i class="fas fa-home mr-2"></i>Về trang chủ
                    </a>
                </div>
            </div>
        @endif
        <footer class="absolute bottom-0 left-0 w-full bg-main border-t text-center py-1 text-sm">
            <small>
                Copyright &copy; 2025
                <a href="https://www.facebook.com/servertp/" class="text-blue-500 underline">TPSERVER
                    VIETNAM</a>. All rights reserved.
                <span>Controller: {{ $controller }}; Action: {{ $action }}; Filter:
                    {{ $filter }}</span>
            </small>
        </footer>
        {{-- Nội dung được bọc trong Livewire LayoutController --}}

        {{-- Nội dung sẽ được render ở đây thông qua livewire --}}


    </div>

</div>
