<nav class="mt-2 max-h-[68vh] overflow-y-auto">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview">
            @section('title',)
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
                        onclick="event.preventDefault(); Livewire.emit('route', 'components', 'create')">
                        <i class="fas fa-plus nav-icon"></i>Thêm mới
                        linh kiện</a>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'components', 'scan')">
                        <i class="fas fa-qrcode nav-icon"></i>
                        <p>Scan/tra cứu linh kiện</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'components', null, 'current-stock')">
                        <i class="fas fa-boxes nav-icon"></i>
                        <p>Đang tồn kho</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'components', null, 'stockout')">
                        <i class="fas fa-pallet nav-icon"></i>
                        <p>Đã xuất kho</p>
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
