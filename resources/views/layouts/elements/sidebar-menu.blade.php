<nav class="mt-3 max-h-[64vh] overflow-y-auto">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
                        onclick="event.preventDefault(); Livewire.emit('route', 'components', 'create')">
                        <i class="fas fa-plus nav-icon"></i>
                        <p>Thêm mới linh kiện</p>
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
                        onclick="event.preventDefault(); Livewire.emit('route', 'components', null, 'current-stockout')">
                        <i class="fas fa-pallet nav-icon"></i>
                        <p>Đã xuất kho</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                    Khách hàng
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'customers', 'create')">
                        <i class="fas fa-plus nav-icon"></i>
                        <p>Thêm mới khách hàng</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'customers', 'index','customers')">
                        <i class="fas fa-address-card nav-icon"></i>
                        <p>Danh sách khách hàng</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-store"></i>
                <p>
                    Đối tác
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'vendors', 'create')">
                        <i class="fas fa-plus nav-icon"></i>
                        <p>Thêm mới đối tác</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'vendors', 'index','vendors')">
                        <i class="fas fa-address-card nav-icon"></i>
                        <p>Danh sách đối tác</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-map-marker-alt"></i>
                <p>
                    Vị trí
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'locations', 'create')">
                        <i class="fas fa-plus nav-icon"></i>
                        <p>Thêm mới vị trí</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'locations', 'index','locations')">
                        <i class="fas fa-address-card nav-icon"></i>
                        <p>Danh sách vị trí</p>
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
                    <a href="#" onclick="event.preventDefault();Livewire.emit('route', 'stats','stock-variation')"
                        class="nav-link">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <p>Biến động tồn kho</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="event.preventDefault();Livewire.emit('route', 'stats','index')"
                        class="nav-link">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <p>Thống kê linh kiện</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Người dùng
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'users', 'create')">
                        <i class="fas fa-plus nav-icon"></i>
                        <p>Thêm mới người dùng</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'users', 'index')">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Danh sách người dùng</p>
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
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'roles', 'index')">
                        <i class="fas fa-user-tag nav-icon"></i>
                        <p>Quản lý vai trò</p>
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
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'exports', 'index')">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                        <p>Tải xuống dữ liệu</p>
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
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'logs', 'user-action', 'user-action-log')">
                        <i class="fas fa-user-clock nav-icon"></i>
                        <p>Nhật ký hoạt động</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); Livewire.emit('route', 'logs', 'stockout', 'component-logs')">
                        <i class="fas fa-business-time"></i>
                        <p>Nhập & xuất kho</p>
                    </a>
                </li>
            </ul>
        </li>


    </ul>
</nav>
