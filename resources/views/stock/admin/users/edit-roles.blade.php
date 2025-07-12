@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Gán vai trò cho người dùng: <span class="text-primary">{{ $user->alias }}</span></h4>

    <form action="{{ route('users.update-roles', $user->id) }}" method="POST" class="bg-light p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-4">
            @foreach ($roles as $role)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio"
                    name="roles[]" id="role_{{ $role->id }}"
                    value="{{ $role->name }}"
                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                <label class="form-check-label" for="role_{{ $role->id }}">
                    {{ ucfirst($role->name) }}
                </label>
            </div>
            @endforeach
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Lưu thay đổi
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>
    </form>
</div>
@endsection
