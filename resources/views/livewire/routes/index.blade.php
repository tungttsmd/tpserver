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

    <div class="flex-col flex justify-between grow h-[100vh]">

        @if ($controller === 'components')
            @if ($action === 'scan')
                @section('title', 'Scan linh kiện')
                <livewire:features.components.component-scan-livewire wire:key="{{ $refresh }}" />
            @elseif ($action === 'create')
                <livewire:features.components.component-create-livewire wire:key="{{ $refresh }}" />
            @else
                <livewire:features.components.component-index-livewire :filter="$filter"
                    wire:key="{{ $refresh }}" />
            @endif
        @else
            <div class="bg-white-100 flex items-center justify-center h-screen p-6 grow rounded">
                <div class="text-main text-center max-w-md">
                    <div class="text-8xl font-bold text-blue-600 mb-4 text-main ">
                        <i class="text-main fas fa-exclamation-triangle"></i> 404
                    </div>
                    <h1 class="text-main text-3xl font-semibold text-gray-800 mb-2">Không tìm thấy trang</h1>
                    <p class="text-gray-600 mb-6">
                        Trang bạn đang tìm có thể đã bị xoá hoặc không còn tồn tại.<br>Vui lòng kiểm tra lại đường dẫn
                        hoặc quay về trang chính.
                    </p>
                    <a href="/"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white bg-main font-semibold px-6 py-3 rounded-xl shadow transition">
                        <i class="fas fa-home mr-2"></i>Về trang chủ
                    </a>
                </div>
            </div>
        @endif

        {{-- Nội dung được bọc trong Livewire LayoutController --}}

        {{-- Nội dung sẽ được render ở đây thông qua livewire --}}


    </div>

</div>
