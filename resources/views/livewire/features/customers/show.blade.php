@section('title', 'Chi tiết khách hàng')

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">
                Thông tin khách hàng
            </h3>
            <div class="flex space-x-2">
                <a href="{{ route('customer.edit', $customer->id) }}" 
                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <i class="fas fa-edit mr-1"></i> Chỉnh sửa
                </a>
                <a href="{{ route('customer.index') }}" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-1"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
    
    <div class="px-6 py-4">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="flex-1 space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Thông tin cơ bản</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Họ và tên</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->name ?? 'Chưa xác định' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Số điện thoại</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->phone ?? 'Chưa xác định' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->email ?? 'Chưa xác định' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Thông tin khác</h4>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Địa chỉ</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->address ?? 'Chưa cập nhật' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Ghi chú</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->note ?? 'Không có ghi chú' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Thông tin bổ sung</h4>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Ngày tạo</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Cập nhật lần cuối</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>


    {{-- Recent Orders Section --}}
    <div class="px-6 py-4 border-t border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-medium text-gray-900">Đơn hàng gần đây</h4>
            @if($customer->orders->count() > 0)
                <a href="{{ route('orders.index', ['customer_id' => $customer->id]) }}" 
                   class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    Xem tất cả ({{ $customer->orders->count() }})
                </a>
            @endif
        </div>
        
        @if($customer->orders->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @foreach($customer->orders->sortByDesc('order_date')->take(5) as $order)
                        <li>
                            <a href="{{ route('orders.show', $order->id) }}" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-blue-600 truncate">
                                            #{{ $order->order_number }}
                                        </p>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ 
                                                    $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                    ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                                    ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'))
                                                }}">
                                                {{ ucfirst($order->status) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-gray-500">
                                                <i class="far fa-calendar-alt mr-1.5 flex-shrink-0"></i>
                                                {{ $order->order_date->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                            <i class="fas fa-money-bill-wave mr-1.5 flex-shrink-0"></i>
                                            {{ number_format($order->total_amount, 0, ',', '.') }} đ
                                        </div>
                                    </div>
                                    @if($order->notes)
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 truncate">
                                                <i class="far fa-sticky-note mr-1.5"></i>
                                                {{ $order->notes }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-gray-50 p-4 rounded-lg text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Không có đơn hàng nào</h3>
                <p class="mt-1 text-sm text-gray-500">Khách hàng này chưa có đơn hàng nào.</p>
                <div class="mt-6">
                    <a href="{{ route('orders.create', ['customer_id' => $customer->id]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus -ml-1 mr-2 h-5 w-5"></i>
                        Tạo đơn hàng mới
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
