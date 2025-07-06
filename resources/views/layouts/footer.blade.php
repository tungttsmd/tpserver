<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Admin panel by TPSERVER
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2025 <a href="https://www.facebook.com/servertp/">TPSERVER VIETNAM</a>.</strong> All rights
    reserved.
</footer>
<style>
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
</style>

</div>
