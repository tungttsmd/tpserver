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
    @livewireStyles

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include ('layouts.headerNav')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <!-- Sidebar -->
            <div class="tp-server sidebar">
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="brand-link-bg">
                </a>
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel pt-3 pb-3 mb-1 d-flex align-items-start">
                    <div class="image me-3" style="position: relative">
                        <a href="{{ route('users.show', auth()->user()->id) }}">
                            @php
                                $mainRole = Str::slug(auth()->user()->getRoleNames()->first() ?? 'user');
                            @endphp

                            <img src="{{ asset(auth()->user()->avatar_url) }}"
                                onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';"
                                class="img-circle elevation-2 object-cover user-avatar border-role-{{ $mainRole }}"
                                alt="User Image" style="width: 60px; height: 60px; object-fit: cover;">

                        </a>
                        <div class="user-roles"
                            style="position: absolute; bottom: -10px; display: flex; width: 100%; justify-content: center;">
                            @foreach (auth()->user()->getRoleNames() as $role)
                                <span class="role-badge role-{{ Str::slug($role) }}">{{ $role }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="info">
                        <a href="{{ route('users.show', auth()->user()->id) }}" class="user-alias d-block mb-1 fw-bold">
                            <b>{{ auth()->user()->alias }}</b>
                        </a>

                        <div class="user-username mb-1" style="font-style: italic; font-size: 0.9rem;">
                            <a href="{{ route('users.show', auth()->user()->id) }}"
                                style="text-decoration: none; color: inherit;">
                                {{ '@' . auth()->user()->username }}
                            </a>
                        </div>


                    </div>
                </div>



                <!-- SidebarSearch Form -->
                <form method="POST" action="{{ route('components.scanpost') }}">
                    @csrf
                    {{-- SERIAL NUMBER tách riêng để thêm autofocus --}}
                    <div class="scan-box mb-2 mt-2 p-2">
                        <div class="input-group">
                            <button type="submit" style="border-top-right-radius: 0px; border-bottom-right-radius: 0px"
                                class="btn bg-main btn-hover">
                                <i class="fas fa-qrcode mr-2"></i> Scan
                            </button>
                            <input type="text" name="serial_number" id="serial_number"
                                class="flex-fill form-control input-hover" value="{{ old('serial_number') }}" required
                                placeholder="Scan linh kiện..." autofocus>
                        </div>
                    </div>
                </form>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Linh kiện
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link"
                                        onclick="Livewire.emit('changeView', 'component-form-create')">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Thêm mới linh kiện</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link"
                                        onclick="Livewire.emit('changeView', 'component-form-scan')">
                                        <i class="fas fa-qrcode mr-2 nav-icon"></i>
                                        <p>Scan/tra cứu linh kiện</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link"
                                        onclick="Livewire.emit('changeView', 'component-index')">
                                        <i class="fas fa-boxes nav-icon"></i>
                                        <p>Danh sách kho hàng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link"
                                        onclick="Livewire.emit('changeView', 'component-stock')">
                                        <i class="fas fa-pallet nav-icon"></i>
                                        <p>Sản phẩm còn hàng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link"
                                        onclick="Livewire.emit('changeView', 'component-export')">
                                        <i class="fas fa-truck-loading nav-icon"></i>
                                        <p>Danh sách xuất kho</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-download"></i>
                                <p>
                                    Tải xuống
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('components.download', ['type' => 'xlsx']) }}" class="nav-link">
                                        <i class="far fa-file-excel nav-icon"></i>
                                        <p>Tải xuống .xlsx</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('components.download', ['type' => 'xls']) }}" class="nav-link">
                                        <i class="fas fa-file-excel nav-icon"></i>
                                        <p>Tải xuống .xls</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('components.download', ['type' => 'html']) }}"
                                        class="nav-link">
                                        <i class="far fa-file-code nav-icon"></i>
                                        <p>Tải xuống .html</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('components.download', ['type' => 'csv']) }}" class="nav-link">
                                        <i class="fas fa-file-csv nav-icon"></i>
                                        <p>Tải xuống .csv</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('components.download', ['type' => 'pdf']) }}" class="nav-link">
                                        <i class="far fa-file-pdf nav-icon"></i>
                                        <p>Tải xuống .pdf</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('components.download', ['type' => 'ods']) }}" class="nav-link">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>Tải xuống .ods</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('logs.download') }}" class="nav-link">
                                        <i class="fas fa-clipboard-list nav-icon"></i>
                                        <p>Tải xuống nhật ký</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-chart-pie nav-icon "></i>
                                <p>
                                    Thống kê
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('static.index') }}" class="nav-link">
                                        <i class="fas fa-chart-bar nav-icon"></i>
                                        <p>Thống kê linh kiện</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fa fa-user-friends nav-icon"></i>
                                <p>
                                    Người dùng
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                        <i class="fas fa-id-card nav-icon"></i>
                                        <p>Quản lý người dùng</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-lock"></i>
                                <p>
                                    Phân quyền
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link">
                                        <i class="fa fa-user-tag nav-icon"></i>
                                        <p>Quản lý phân quyền</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Lịch sử
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('logs.index') }}" class="nav-link">
                                        <i class="fas fa-clock nav-icon"></i>
                                        <p>Nhật ký hoạt động</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('logs.index-component-export') }}" class="nav-link">
                                        <i class="fas fa-clock nav-icon"></i>
                                        <p>Lịch sử xuất kho</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('logs.index-component-recall') }}" class="nav-link">
                                        <i class="fas fa-clock nav-icon"></i>
                                        <p>Lịch sử thu hồi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /. sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <style>
            i.fa,
            i.fas {
                min-width: 24px;
                min-height: 24px;
                display: inline-flex;
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            .user-panel {
                max-width: 350px;
                box-shadow: 0px -5px 5px rgba(75, 108, 183, 0.5);
            }

            .user-panel:hover {
                filter: brightness(1.2);

            }

            ul.nav-treeview li a.nav-link {
                padding-left: 30px;

            }

            li.has-treeview {
                margin: auto
            }

            .has-treeview>.nav-link>p {
                font-weight: 650;
            }

            .has-treeview>.nav-link {
                padding-left: 10px;
            }

            .user-panel:hover {
                background-color: lightsteelblue transparent !important;
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
                cursor: pointer;
            }

            .role-badge {
                display: inline-block;
                padding: 2px 10px;
                border-radius: 12px;
                font-size: 0.75rem;
                font-weight: 600;
                color: #fff;
                margin: 0 4px;
                text-transform: capitalize;
            }

            /* Role-specific colors */
            .role-admin {
                background-color: #dc3545;
                /* red */
            }

            .role-manager {
                background-color: #ffc107;
                /* yellow */
                color: #212529;
            }

            .role-user {
                background-color: #17a2b8;
                /* blue */
            }

            .bg-main {
                background-color: #4b6cb7 !important;
                color: white !important;
            }

            .user-avatar {
                border-radius: 50%;
                border: 4px solid transparent;
                transition: border-color 0.3s ease;
            }

            /* Border theo role */
            .border-role-admin {
                border-color: #dc3545;
                /* đỏ */
            }

            .border-role-manager {
                border-color: #ffc107;
                /* vàng */
            }

            .border-role-user {
                border-color: #17a2b8;
                /* xanh */
            }

            .user-alias:hover,
            .user-username a:hover {
                color: #0d6efd;
                text-decoration: underline;
            }

            .user-username {
                color: #c2c7d0;

            }

            .scan-box:hover {
                filter: brightness(1.12);

            }

            .tp-server .nav-link.active {
                background-color: #4b6cb7;
            }

            .brand-link-bg {
                display: flex;
                align-items: center;
                justify-content: center;
                /* canh giữa text */
                height: 120px;
                /* chiều cao bạn muốn */
                width: 100%;
                /* hoặc cố định chiều rộng nếu cần */
                color: white;
                font-weight: 300;
                font-size: 1.25rem;
                text-decoration: none;

                /* background ảnh logo */
                background-image: url('{{ asset('img/logo.jpg') }}');
                background-size: cover;
                /* fit rộng đầy đủ */
                background-position: center center;
                background-repeat: no-repeat;

                /* nếu muốn hiệu ứng mờ nền để chữ nổi bật */
                position: relative;
                overflow: hidden;
                filter: brightness(1.2);
                /* tăng sáng 20% */
            }

            .brand-link-bg:hover {
                filter: brightness(1.8);

            }

            .brand-link-bg>.brand-text {
                position: relative;
                z-index: 2;
            }

            .tp-server {
                padding: 0;

            }

            .text-main {
                color: #4b6cb7 !important;
            }

            .bright-hover:hover {
                filter: brightness(1.8);

            }

            .scale-hover:hover {
                transform: scale(1.1);
            }

            .tpserver .disable-click {
                pointer-events: none !important;
                /* KHÔNG nhận sự kiện chuột */
            }

            .tpserver .recenterDiv {
                justify-content: space-between !important;
                margin-right: 0.75rem !important;
            }

            .tpserver .border-main {
                border: 1px solid orange !important;
                border-radius: 4px !important;
            }

            .tpserver .btn-hover-warning:hover {
                background-color: limegreen !important;
                border: 1px solid limegreen !important;
                transform: scale(1.02);
            }
        </style>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <livewire:layout-content />
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
        <!-- jQuery -->
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
        <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
        <script>
            // Xử lý thao tác cho máy scanner: Lắng nghe phím bất kỳ ngoài input để focus lại input và chọn hết nội dung
            document.addEventListener('keydown', function(e) {
                // Xử lý thao tác cho máy scanner
                const input = document.getElementById('scanInputFocus');
                if (!input) return;

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        // Không preventDefault, để form Livewire vẫn xử lý submit
                        // Chỉ blur để rút focus sau khi submit được kích hoạt
                        setTimeout(() => input.blur(), 0);
                    }
                });

                // Khi nhấn Enter trong input, blur để rút focus (không ngăn submit)
                if (document.activeElement !== input) {
                    // Bỏ qua các phím điều khiển (tab, shift,...)
                    if (!['Tab', 'Shift', 'Control', 'Alt', 'Meta'].includes(e.key)) {
                        input.focus();
                        input.select();
                    }
                }
            });

            // Xử lý thao tác cho nút Xem của suggestions
            function triggerManualScan(serialNumber) {
                const input = document.querySelector('#scanInputBox input');
                input.value = serialNumber;
                input.dispatchEvent(new Event('input')); // Cập nhật wire:model.defer
                document.getElementById('formTriggerLivewire').requestSubmit();
            }

            function triggerRealtimeScan(serialNumber) {
                const input = document.querySelector('#scanInputBox input');
                input.value = serialNumber;
                input.dispatchEvent(new Event('input'));
            }
        </script>
        @livewireScripts
</body>

</html>
