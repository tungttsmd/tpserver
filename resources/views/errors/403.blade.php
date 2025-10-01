@extends('layouts.app')

@section('content')
    <div class="flex-1 flex flex-col items-center justify-center p-4">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-sm p-8">
            <div class="text-center space-y-6">
                <!-- Error Icon -->
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-50">
                    <svg class="h-16 w-16 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <!-- Error Message -->
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold text-gray-900">Truy cập bị từ chối</h1>
                    <p class="text-gray-600">
                        Bạn không có quyền truy cập trang này. Vui lòng liên hệ quản trị viên nếu đây là sự nhầm lẫn.
                    </p>
                    <p class="text-sm text-gray-500">Mã lỗi: 403 Forbidden</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center pt-4">
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Quay lại
                    </a>
                    <a href="{{ route('index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
