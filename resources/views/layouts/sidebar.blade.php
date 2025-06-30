<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">TPServer Admin </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(auth()->user()->avatar_url) }}" class="img-circle elevation-2 object-cover"
                    alt="User Image" style="width: 60px; height: 60px; object-fit: cover;">
                </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->alias }}</a>
                <a href="#" class="d-block">{{ auth()->user()->username }}
                    ({{ auth()->user()->getRoleNames()->implode(', ') }})</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('components.create') }}" class="nav-link">
                        <i class="fas fa-plus nav-icon"></i>
                        <p>Thêm mới linh kiện</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('components.store') }}" class="nav-link">
                        <i class="fas fa-boxes nav-icon"></i>
                        <p>Danh sách kho hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('components.stock') }}" class="nav-link">
                        <i class="fas fa-pallet nav-icon"></i>
                        <p>Sản phẩm còn hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('components.export') }}" class="nav-link">
                        <i class="fas fa-truck-loading nav-icon"></i>
                        <p>Danh sách xuất kho</p>
                    </a>
                </li>
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
                    <a href="{{ route('components.download', ['type' => 'html']) }}" class="nav-link">
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
                    <a href="{{ route('logs.index') }}" class="nav-link">
                        <i class="fas fa-clock nav-icon"></i>
                        <p>Nhật ký</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Quản lý phân quyền</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Quản lý người dùng</p>
                    </a>
                </li>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Inactive Page</p>
                        </a>
                    </li>
                </ul>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Starter Pages
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Active Page</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inactive Page</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh sách linh kiện
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Thêm linh kiện
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh sách linh kiện
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh sách linh kiện
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh sách linh kiện
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
