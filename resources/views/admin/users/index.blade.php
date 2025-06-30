@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h4 class="mb-3">Danh sách người dùng</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive rounded shadow-sm">
            <table class="table table-bordered text-center align-middle custom-table bg-light">
                <thead class="bg-primary text-white">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 25%">Alias</th>
                        <th style="width: 25%">Username</th>
                        <th style="width: 15%">Role</th>
                        <th style="width: 15%">Permissions</th>
                        <th style="width: 15%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td class="text-start">{{ $user->alias }}</td>
                            <td class="text-start">{{ $user->username }}</td>
                            <td>
                                {{ $user->getRoleNames()->implode(', ') }}
                            </td>
                            <td>
                                {{ $user->getAllPermissions()->count() }}
                            </td>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit-roles', $user->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-cogs mr-2"></i> Đổi vai trò
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Chưa có người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .custom-table td,
        .custom-table th {
            vertical-align: middle;
            background-color: #f0f4ff !important;
        }

        .custom-table tr:hover td {
            background-color: #e8f0ff !important;
        }

        .custom-table thead th {
            background-color: #4b6cb7 !important;
            color: white !important;
        }

        .table td,
        .table th {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
