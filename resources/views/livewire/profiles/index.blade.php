@php
    $roleColor = $data['role']->role_color ?? '#4b6cb7';
@endphp

<div class="tpserver container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg rounded-xl">
                {{-- Avatar và cover --}}
                <div style="margin-bottom: 64px; border-top-left-radius: 12px;border-top-right-radius: 12px; border: 2px solid {{ $roleColor }}"
                    class="inline-flex col-12 items-end text-center bg-[url('{{ $data['user']->cover_url }}')] bg-cover bg-no-repeat bg-center">
                    <img src="{{ asset($data['user']->avatar_url) }}"
                        onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';"
                        class="img-circle elevation-2 object-cover" alt="User Image"
                        style="margin-bottom: -48px; width: 160px; height : 160px; object-fit: cover; margin-top: 20px; border: 8px solid {{ $roleColor }}";
                        border-radius: 50%;">
                    <h5 class="pl-4 pr-4 pt-1 pb-1 rounded-full mt-3 h2"
                        style="color: {{ $roleColor }}; margin-bottom: -45px; padding: 0px;">
                        <strong>{{ $data['user']->alias }}</strong>
                    </h5>
                </div>
                <div class="flex row justify-between gap-4 w-full">
                    {{-- Thông tin người dùng --}}
                    <div class="col-md-9">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>ID:</strong> {{ $data['user']->id }}</li>
                            <li class="list-group-item"><strong>Username:</strong>
                                {{ $data['user']->username }}</li>
                            <li class="list-group-item"><strong>Alias:</strong> {{ $data['user']->alias }}
                            </li>
                            <li class="list-group-item"><strong>Vai trò:</strong>
                                {{ $data['user']->getRoleNames()->implode(', ') ?: 'Không có' }}
                            </li>

                        </ul>
                    </div>
                    <div>
                        <strong>Quyền:</strong>
                        <ul class="mt-2 mb-0 ps-3">
                            @forelse($data['user']->getAllPermissions() as $permission)
                                <li>{{ $permission->display_name }}</li>
                            @empty
                                <li>Không có quyền nào</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="mt-4">
                    <div
                        class="d-flex flex-wrap align-items-center gap
                            {{ $data['user']->canEditUser() ? 'justify-content-between' : 'justify-content-end' }}">

                        {{-- Các nút chỉ hiển thị nếu là chính mình --}}
                        @if ($data['user']->canEditUser())
                            <div class="d-flex flex-wrap gap">
                                <livewire:component-controller component='change-avatar' />
                                

                                <a href="{{ route('profile.edit-alias', $data['user']->id) }}"
                                    class="btn btn-outline-primary">
                                    <i class="fas fa-user-edit mr-2"></i> Sửa alias
                                </a>
                                @if ($data['user']->canEditPassword())
                                <livewire:component-controller component='change-password' />
                                @endif
                                <livewire:component-controller component='button-logout-2' />
                            </div>
                        @endif

                        {{-- Nút Quay lại luôn hiển thị --}}
                        <div>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .tpserver .gap {
        gap: 20px;
        justify-content: space-between;
    }

    .bg-light-subtle {
        background-color: #f9fafc;
    }

    .list-group-item {
        background-color: transparent;
        padding: 8px 12px;
    }

    .btn:hover {
        transform: scale(1.02);
        transition: all 0.2s ease-in-out;
    }
</style>
