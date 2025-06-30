@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h4 class="mb-3">Danh sách nhóm quyền</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif

        <div class="table-responsive rounded shadow-sm">
            <table
                class="fixed-table table table-bordered text-center align-middle bg-primary-subtle text-dark rounded custom-table">
                <thead class="bg-primary text-white">
                    <tr>
                        <th style="width: 10%">ID</th>
                        <th style="width: 30%">Tên nhóm quyền</th>
                        <th style="width: 30%">Số lượng quyền</th>
                        <th style="width: 30%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td class="text-left">{{ $role->name }}</td>
                            <td>{{ $role->permissions->count() }}</td>
                            <td>
                                <a href="{{ route('roles.permissions.edit', $role->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-cogs mr-2"></i> Chỉnh sửa quyền hạn của vai trò
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="container-fluid">
            <div class="d-flex justify-content-end mt-3 mb-3">
                <a href="{{ route('roles.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle mr-2"></i> Tạo vai trò mới
                </a>
            </div>
        </div>

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

        .fixed-table {
            table-layout: fixed;
            width: 100%;
            margin-bottom: 0 !important;
        }

        .fixed-table th,
        .fixed-table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
