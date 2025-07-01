@include ('layouts.head')
<!-- Navbar -->
@include ('layouts.headerNav')
<!-- /.navbar -->

<!-- Main Sidebar Container -->
@include ('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        @yield('content')
    </div>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
@include ('layouts.notiModalControl')
<!-- /.control-sidebar -->

<!-- Main Footer -->
@include('layouts.footer')
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('layouts.javascript')
