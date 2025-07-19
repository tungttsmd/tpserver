<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TP Server Dashboard</title>

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Custom & Livewire --}}
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar cố định --}}
        <aside
            class="relative flex flex-col h-full tp-server layouts sidebar main-sidebar sidebar-dark-primary bg-dark-main elevation-4">

            @include('layouts.elements.sidebar-user')
            @include('layouts.elements.sidebar-menu')
            @include('layouts.elements.sidebar-cover')

        </aside>


        {{-- Nội dung chính + footer --}}
        <div class="tp-server layouts content-wrapper flex flex-col flex-1 overflow-hidden">

            {{-- Main content + footer sticky --}}
            <div class="bg-white flex flex-col flex-1 ">
                <main class="relatvie flex-1 p-0 overflow-y-auto">
                    <livewire:route-controller />

                </main>
            </div>

        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="{{ asset('js/layouts/app.js') }}"></script>
    <script src="{{ asset('js/layouts/modal.js') }}"></script>
    @livewireScripts

</body>

</html>
