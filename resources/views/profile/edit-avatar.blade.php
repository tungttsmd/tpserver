
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Cập nhật ảnh đại diện</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update-avatar') }}" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="avatar" class="form-label">Chọn ảnh mới (jpg, png, tối đa 2MB):</label>
            <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*" required>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Cập nhật ảnh</button>
            <a href="{{ route('users.show', auth()->id()) }}" class="btn btn-secondary ms-2">Quay lại</a>
        </div>
    </form>
</div>
@endsection
