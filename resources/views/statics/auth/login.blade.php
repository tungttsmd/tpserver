<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-xl">
        <h2 class="text-2xl font-bold text-center mb-6">Đăng nhập hệ thống</h2>

        @if(session('error'))
            <div class="mb-4 p-3 text-sm text-red-600 bg-red-100 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth.loginpost') }}" class="space-y-6">
            @csrf

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required autofocus
                       class="mt-1 w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                <input type="password" name="password" id="password" required
                       class="mt-1 w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2 text-sm">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <span>Ghi nhớ đăng nhập</span>
                </label>
                <a href="#" class="text-sm text-blue-600 hover:underline">Quên mật khẩu?</a>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">
                Đăng nhập
            </button>
        </form>
    </div>
</body>
</html>
