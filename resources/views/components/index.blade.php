@extends('layouts.app')

@section('title', 'Quản lý linh kiện')

@php
    $currentSort = request('sort', 'id');
    $currentDir = request('dir', 'desc');

    // Hàm tạo header có sort link
    function sortHeader($label, $column)
    {
        $currentSort = request('sort', 'id');
        $currentDir = request('dir', 'desc');
        $newDir = $currentSort === $column && $currentDir === 'asc' ? 'desc' : 'asc';
        $icon = $currentSort === $column ? 'fa-sort-amount-' . ($currentDir === 'asc' ? 'up' : 'down') : 'fa-sort';
        $url = route('components.index', array_merge(request()->all(), ['sort' => $column, 'dir' => $newDir]));
        return "<a href='{$url}' class='text-white text-decoration-none'>{$label} <i class='fas {$icon} ms-1'></i></a>";
    }
@endphp

@section('content')
    @include('layouts.table', ['components' => $components])
@endsection
