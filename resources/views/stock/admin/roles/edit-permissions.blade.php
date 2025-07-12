@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4">Gán quyền cho vai trò: <span class="text-primary">{{ ucfirst($role->name) }}</span></h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('roles.permissions.update', $role) }}" method="POST"
            class="p-4 bg-white border rounded shadow-sm">
            @csrf
            @method('PUT')

            <div class="row">
                @foreach ($permissions->chunk(6) as $chunk)
                    <div class="col-md-4">
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                @foreach ($chunk as $permission)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="perm_{{ $permission->id }}"
                                            name="permissions[]" value="{{ $permission->name }}"
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label
                                            class="form-check-label"style="font-weight: {{ $role->hasPermissionTo($permission->name) ? '700' : '400' }}"
                                            for="perm_{{ $permission->id }}">
                                            {{ $permission->display_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Lưu thay đổi
                </button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
@endsection
