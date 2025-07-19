<div class="tpserver components w-full">
    {{-- Header --}}
    @yield('prop')
    @include('layouts.elements.content-header')
    <div class="tpserver layouts pt-0 px-4 pb-12">
        @yield('content')
    </div>
</div>
