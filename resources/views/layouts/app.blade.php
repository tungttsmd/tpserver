<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TP Server Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Layout custom style --}}
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">

    {{-- Livewire style --}}
    @livewireStyles

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="tp-server layouts main-header p-1 shadow-sm navbar navbar-expand navbar-white navbar-light">
            <div class="flex-nowrap justify-between inline-flex gap-5"style="width: 100%">
                <div class="row w-full">
                    <div class="col-6 flex-nowrap inline-flex gap-8 pl-3">
                        {{-- headernav push menu button --}}
                        @include('layouts.elements.headernav-push-menu')

                        {{-- headerNav title --}}
                        @include('layouts.elements.headernav-title')
                    </div>

                    <div class="col-6 flex-nowrap inline-flex gap-2 p-0">
                        {{-- headerNav scan --}}
                        @include('layouts.elements.headernav-scan')

                        {{-- headerNav logout --}}
                        <livewire:component-controller component='button-logout' />
                    </div>
                </div>
            </div>
        </nav>

        {{-- Sidebar --}}
        <aside class="tp-server layouts sidebar main-sidebar sidebar-dark-primary elevation-4">
            <div>
                {{-- Sidebar banner --}}
                @include('layouts.elements.sidebar-cover')

                {{-- Sidebar user --}}
                @include('layouts.elements.sidebar-user')

                {{-- Sidebar menu --}}
                @include('layouts.elements.sidebar-menu')
            </div>
        </aside>


        <div class="tp-server layouts content-wrapper p-2">
            {{-- Main content by livewire controller --}}
            @include('layouts.elements.content')
        </div>

        {{-- Footer --}}
        @include('layouts.elements.footer')

    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>

    {{-- Layout custom script --}}
    <script src="{{ asset('js/layouts/app.js') }}"></script>

    {{-- Livewire script --}}
    @livewireScripts
</body>

</html>
