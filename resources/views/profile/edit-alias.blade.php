
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Sửa Alias</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update-alias') }}" method="POST" class="bg-light p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="alias" class="form-label">Alias mới</label>
            <input type="text" name="alias" id="alias" class="form-control" value="{{ old('alias', auth()->user()->alias) }}" required>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            <a href="{{ route('users.show', auth()->id()) }}" class="btn btn-secondary ms-2">Quay lại</a>
        </div>
    </form>
</div>
@endsection
