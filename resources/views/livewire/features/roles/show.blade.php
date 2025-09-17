<div class="space-y-6">
    @if($role)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Thông tin vai trò: {{ $role->display_name ?? $role->name }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Danh sách các quyền được gán cho vai trò này
                </p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Tên hiển thị</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $role->display_name }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Tên hệ thống</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $role->name }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Danh sách quyền
                </h3>
            </div>
            <div class="border-t border-gray-200">
                @foreach($role->permissions as $permission)
                    <p>{{ $permission->display_name ?? $permission->name }}</p>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">Không tìm thấy thông tin vai trò</p>
        </div>
    @endif
    @dd($permissions)
</div>
