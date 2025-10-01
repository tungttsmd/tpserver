<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    .submenu {
        display: none;
        padding-left: 20px;
    }

    .submenu.show {
        display: block;
    }
</style>

<style>
    .logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 1rem;
    }

    .logo {
        font-size: 1.5rem;
        font-weight: bold;
        color: #3b82f6;
        /* blue-500 */
        text-decoration: none;
        transition: color 0.2s;
    }

    .logo:hover {
        color: #2563eb;
        /* blue-600 */
    }
</style>

<nav x-data>
    <div class="logo-container">
        <a href="{{ route('index') }}" class="logo">
            <div class="flex items-center">
                <img class="filter drop-shadow-md" width="128" src="{{ asset('img/logo-tpserver.png') }}"
                    alt="TP Server">
            </div>
        </a>
    </div>
    <ul class="list-none p-0">
        <li class="menu-item">
            <a href="{{ route('item.create') }}" class="toggle">
                <i class="fa fa-angle-right"></i>
                <span>Linh kiện</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('item.create') }}">Thêm mới linh kiện</a></li>
                <li><a href="{{ route('item.index') }}">Danh sách linh kiện</a></li>
                <li><a href="{{ route('item.stockout') }}">Linh kiện xuất kho</a></li>
            </ul>
        </li>

        <!-- Khách hàng -->
        <li class="menu-item">
            <a href="{{ route('customer.create') }}" class="toggle">
                <i class="fa fa-angle-right"></i>
                <span>Khách hàng</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('customer.create') }}">Thêm mới khách hàng</a></li>
                <li><a href="{{ route('customer.index') }}">Danh sách khách hàng</a></li>
            </ul>
        </li>

        <!-- Tương tự cho các mục khác -->
        <li class="menu-item">
            <a href="{{ route('vendor.create') }}" class="toggle">
                <i class="fa fa-angle-right"></i>
                <span>Đối tác</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('vendor.create') }}">Thêm mới đối tác</a></li>
                <li><a href="{{ route('vendor.index') }}">Danh sách đối tác</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="{{ route('location.create') }}" class="toggle">
                <i class="fa fa-angle-right"></i>
                <span>Vị trí</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('location.create') }}">Thêm mới vị trí</a></li>
                <li><a href="{{ route('location.index') }}">Danh sách vị trí</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="toggle">
                <i class="fa fa-angle-right"></i>
                <span>Thống kê</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('stats.stock-variation') }}">
                        Biến động tồn kho</a></li>
                <li><a href="{{ route('stats.index') }}">
                        Thống kê linh kiện</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="toggle">
                <i class="fa fa-angle-right"></i>
                <span>Người dùng</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('user.create') }}">Tạo mới tài khoản</a></li>
                <li><a href="{{ route('user.index') }}">Danh sách tài khoản</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="toggle">
                <i class="fa fa-angle-right"></i>
                <span>Phân quyền</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('role.create') }}">Tạo mới vai trò</a></li>
                <li><a href="{{ route('role.authorize') }}">Phân quyền người dùng</a></li>
                <li><a href="{{ route('role.index') }}">Quản lý vai trò</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="toggle">
                <i class="fa fa-angle-right"></i>
                <span>Tải xuống</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('export.index') }}">Tải xuống dữ liệu</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="toggle">
                <i class="fa fa-angle-right"></i>
                <span>Lịch sử</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('log.users') }}">Hoạt động người dùng</a></li>
                <li><a href="{{ route('log.items') }}">Nhập & xuất kho</a></li>
            </ul>
        </li>
    </ul>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.menu-item > .toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();

                const parent = this.parentElement;
                const submenu = parent.querySelector('.submenu');
                const icon = this.querySelector('i');

                // Toggle submenu hiện tại
                submenu.classList.toggle('show');

                // Đổi icon
                if (submenu.classList.contains('show')) {
                    icon.classList.replace('fa-angle-right', 'fa-angle-down');
                } else {
                    icon.classList.replace('fa-angle-down', 'fa-angle-right');
                }
            });
        });
    });
</script>
