<div class="livewire-component-container">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Trang quản lý linh kiện</h2>
            <p class="mt-1 text-sm text-gray-500">Quản lý và theo dõi các linh kiện trong kho</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
            <!-- Total Items -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Tổng số</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_components']) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- In Stock -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-50 text-green-600">
                        <i class="fas fa-plane-arrival text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Có sẵn</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ number_format($stats['available_components']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Biến động tồn kho -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-50 text-red-600">
                        <i class="fas fa-plane-departure text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Xuất kho</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ number_format($stats['stockout_components']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Phân loại -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                        <i class="fas fa-boxes text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Phân loại</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_categories']) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="px-6 pb-6">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Hoạt động gần đây</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentActivities as $activity)
                        <div class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <i class="{{ $activity['icon'] ?? 'fas fa-boxes' }} text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity['note'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $activity['component'] }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $activity['time_ago'] }} •
                                        {{ $activity['user'] }} ({{ $activity['username'] }})</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-center text-gray-500">
                            Không có hoạt động gần đây
                        </div>
                    @endforelse
                </div>
                @if (count($recentActivities) > 0)
                    <div class="px-6 py-3 bg-gray-50 text-right">
                        <a href="{{ route('log.items') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Xem tất cả hoạt động
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
