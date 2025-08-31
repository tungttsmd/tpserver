<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <!-- Thêm Bootstrap từ CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Auth login custom css --}}
    <link href="{{ asset('css/auth/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layouts/app.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Phần đăng nhập góc phải -->
    <div class="login-container">
        <a href="{{ url('help') }}">? Hỗ trợ</a>
    </div>

    <!-- Form đăng nhập chính giữa -->
    <div class="form-container">
        <h2 class="text-center">Đăng nhập</h2>

        <form method="POST" action="{{ route('auth.loginpost') }}">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>
                    <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                </label>
            </div>

            <button type="submit" class="btn bg-main hv-opacity w-100">Đăng nhập</button>

            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </form>
    </div>

    <!-- Thêm Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
