<!-- resources/views/admin/roles/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">Tạo vai trò mới</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.store') }}" method="POST" class="bg-light p-4 rounded shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên vai trò</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="VD: admin, manager, user" required>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-plus-circle me-1"></i> Tạo vai trò
            </button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>
    </form>
</div>
@endsection
