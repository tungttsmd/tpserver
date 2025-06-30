<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <!-- Thêm Bootstrap từ CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            background: url('{{ asset('img/logo.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            position: fixed;
            top: 10px;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 5px;
        }

        .login-container a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .login-container a:hover {
            color: #007bff;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input {
            margin-bottom: 15px;
        }
    </style>
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

            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>

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
