<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My App')</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
</head>

<body class="bg-gray-100">
    <div class="flex justify-center p-4">
        <!-- Container chính, max width 1140px -->
        <div class="w-full max-w-[1140px] flex gap-4">
            <!-- Sidebar -->
            <aside class="w-1/4">
                <x-atoms.flash.alert />
                @include('layouts.elements.sidebar-menu')
            </aside>

            <!-- Main content -->
            <main class="w-3/4">
                {{ $slot }} <!-- Livewire component render tại đây -->
            </main>
        </div>
    </div>

    @livewireScripts
    {{-- <script src="{{ asset('js/layouts/app.js') }}"></script> --}}
</body>


</html>
