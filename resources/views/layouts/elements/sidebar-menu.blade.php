<nav>
    <ul style="list-style:none; padding:0;">
        <li>
            <a href="#" onclick="toggleMenu(event, 'menu1')" style="display:flex;align-items:center;">
                <span id="icon-menu1" class="fa fa-angle-right"
                    style="width:18px;min-width:18px;text-align:center;display:inline-block;"></span>
                <span style="margin-left:4px;">Linh kiện</span>
            </a>
            <ul id="menu1" style="display:none; list-style:none; padding-left:20px;">
                <li><a href="{{ route('item.create') }}">Thêm mới linh kiện</a></li>
                <li><a href="{{ route('item.scan') }}">Scan linh kiện</a></li>
                <li><a href="{{ route('item.index') }}">Danh sách linh kiện</a></li>
                <li><a href="{{ route('item.stockout') }}">Danh sách xuất kho</a></li>
            </ul>
        </li>
        <li>
            <a href="#" onclick="toggleMenu(event, 'menu2')" style="display:flex;align-items:center;">
                <span id="icon-menu2" class="fa fa-angle-right"
                    style="width:18px;min-width:18px;text-align:center;display:inline-block;"></span>
                <span style="margin-left:4px;">Khách hàng</span>
            </a>
            <ul id="menu2" style="display:none; list-style:none; padding-left:20px;">
                <li><a href="{{ route('customer.create') }}">Thêm mới khách hàng</a></li>
                <li><a href="{{ route('customer.index') }}">Danh sách khách hàng</a></li>
            </ul>
        </li>
        <li>
            <a href="#" onclick="toggleMenu(event, 'menu3')" style="display:flex;align-items:center;">
                <span id="icon-menu3" class="fa fa-angle-right"
                    style="width:18px;min-width:18px;text-align:center;display:inline-block;"></span>
                <span style="margin-left:4px;">Đối tác</span>
            </a>
            <ul id="menu3" style="display:none; list-style:none; padding-left:20px;">
                <li><a href="{{ route('vendor.create') }}">Thêm mới đối tác</a></li>
                <li><a href="{{ route('vendor.index') }}">Danh sách đối tác</a></li>
            </ul>
        </li>
        <li>
            <a href="#" onclick="toggleMenu(event, 'menu4')" style="display:flex;align-items:center;">
                <span id="icon-menu4" class="fa fa-angle-right"
                    style="width:18px;min-width:18px;text-align:center;display:inline-block;"></span>
                <span style="margin-left:4px;">Vị trí</span>
            </a>
            <ul id="menu4" style="display:none; list-style:none; padding-left:20px;">
                <li><a href="{{ route('location.create') }}">Thêm mới vị trí</a></li>
                <li><a href="{{ route('location.index') }}">Danh sách vị trí</a></li>
            </ul>
        </li>
        <li>
            <a href="#" onclick="toggleMenu(event, 'menu5')" style="display:flex;align-items:center;">
                <span id="icon-menu5" class="fa fa-angle-right"
                    style="width:18px;min-width:18px;text-align:center;display:inline-block;"></span>
                <span style="margin-left:4px;">Thống kê</span>
            </a>
            <ul id="menu5" style="display:none; list-style:none; padding-left:20px;">
                <li><a href="#"
                        onclick="event.preventDefault();Livewire.emit('route', 'stats','stock-variation')">Biến
                        động tồn
                        kho</a></li>
                <li><a href="#" onclick="event.preventDefault();Livewire.emit('route', 'stats','index')">Thống kê
                        linh kiện</a></li>
            </ul>
        </li>
        <li>
            <a href="#" onclick="toggleMenu(event, 'menu6')" style="display:flex;align-items:center;">
                <span id="icon-menu6" class="fa fa-angle-right"
                    style="width:18px;min-width:18px;text-align:center;display:inline-block;"></span>
                <span style="margin-left:4px;">Người dùng</span>
            </a>
            <ul id="menu6" style="display:none; list-style:none; padding-left:20px;">
                <li><a href="#" onclick="event.preventDefault(); Livewire.emit('route', 'users', 'create')">Thêm
                        mới người dùng</a></li>
                <li><a href="#" onclick="event.preventDefault(); Livewire.emit('route', 'users', 'index')">Danh
                        sách người dùng</a></li>
            </ul>
        </li>
        <li>
            <a href="#" onclick="toggleMenu(event, 'menu7')" style="display:flex;align-items:center;">
                <span id="icon-menu7" class="fa fa-angle-right"
                    style="width:18px;min-width:18px;text-align:center;display:inline-block;"></span>
                <span style="margin-left:4px;">Phân quyền</span>
            </a>
            <ul id="menu7" style="display:none; list-style:none; padding-left:20px;">
                <li><a href="#" onclick="event.preventDefault(); Livewire.emit('route', 'roles', 'index')">Quản lý
                        vai trò</a></li>
            </ul>
        </li>
        <li>
            <a href="#" onclick="toggleMenu(event, 'menu8')" style="display:flex;align-items:center;">
                <span id="icon-menu8" class="fa fa-angle-right"
                    style="width:18px;min-width:18px;text-align:center;display:inline-block;"></span>
                <span style="margin-left:4px;">Tải xuống</span>
            </a>
            <ul id="menu8" style="display:none; list-style:none; padding-left:20px;">
                <li><a href="{{ route('export.index') }}">Tải xuống dữ liệu</a></li>
            </ul>
        </li>
        <li>
            <a href="#" onclick="toggleMenu(event, 'menu9')" style="display:flex;align-items:center;">
                <span id="icon-menu9" class="fa fa-angle-right"
                    style="width:18px;min-width:18px;text-align:center;display:inline-block;"></span>
                <span style="margin-left:4px;">Lịch sử</span>
            </a>
            <ul id="menu9" style="display:none; list-style:none; padding-left:20px;">
                <li><a href="{{ route('log.users') }}">Nhật ký hoạt động</a></li>
                <li><a href="{{ route('log.items') }}">Nhập & xuất kho</a></li>
            </ul>
        </li>
    </ul>
</nav>
<script>
    function toggleMenu(e, id) {
        e.preventDefault();
        var menu = document.getElementById(id);
        var icon = document.getElementById('icon-' + id);
        if (menu.style.display === "none") {
            menu.style.display = "block";
            if (icon) {
                icon.classList.remove('fa-angle-right');
                icon.classList.add('fa-angle-down');
            }
        } else {
            menu.style.display = "none";
            if (icon) {
                icon.classList.remove('fa-angle-down');
                icon.classList.add('fa-angle-right');
            }
        }
    }
</script>
