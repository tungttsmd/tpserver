@extends('layouts.app')

@section('content')
    <div class="tpserver container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg rounded-4">
                    <div class="card-header bg-primary text-white text-center rounded-top-4">
                        <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i> Thông tin người dùng</h4>
                    </div>

                    <div class="card-body bg-light-subtle">
                        <div class="row align-items-center g-4">
                            {{-- Avatar --}}
                            <div class="col-md-3 text-center">
                                <img src="{{ $user->avatar_url ?? asset('dist/img/user2-160x160.jpg') }}"
                                    class="rounded-circle shadow-sm border border-2" width="120" height="120"
                                    style="width: 200px; height: 200px; object-fit: cover;" alt="Avatar">
                                <h5 class="mt-3">{{ $user->alias }}</h5>
                            </div>

                            {{-- Thông tin người dùng --}}
                            <div class="col-md-9">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
                                    <li class="list-group-item"><strong>Username:</strong> {{ $user->username }}</li>
                                    <li class="list-group-item"><strong>Alias:</strong> {{ $user->alias }}</li>
                                    <li class="list-group-item"><strong>Vai trò:</strong>
                                        {{ $user->getRoleNames()->implode(', ') ?: 'Không có' }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Quyền:</strong>
                                        <ul class="mt-2 mb-0 ps-3">
                                            @forelse($user->getAllPermissions() as $permission)
                                                <li>{{ $permission->name }}</li>
                                            @empty
                                                <li><em>Không có quyền nào</em></li>
                                            @endforelse
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div
                                class="d-flex flex-wrap align-items-center gap
                                {{ $user->canEditUser() ? 'justify-content-between' : 'justify-content-end' }}">

                                {{-- Các nút chỉ hiển thị nếu là chính mình --}}
                                @if ($user->canEditUser())
                                    <div class="d-flex flex-wrap gap">
                                        <a href="{{ route('profile.edit-avatar') }}" class="btn btn-outline-info">
                                            <i class="fas fa-image mr-2"></i> Đổi avatar
                                        </a>

                                        <a href="{{ route('profile.edit-alias') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-user-edit mr-2"></i> Sửa alias
                                        </a>
                                        @if ($user->canEditPassword())
                                            <a href="{{ route('profile.edit-password') }}" class="btn btn-outline-warning">
                                                <i class="fas fa-key mr-2"></i> Đổi mật khẩu
                                            </a>
                                        @endif

                                        <form method="POST" action="{{ route('auth.logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                                            </button>
                                        </form>
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
@endsection
