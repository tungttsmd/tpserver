@extends('layouts.content')
@section('prop')
    @php
        $title = 'Danh sách linh kiện';
        $icon = 'fas fa-boxes';
    @endphp
@endsection

@section('content')
    <div class="py-4 w-full">
        {{-- Bộ lọc --}}
        @include('livewire.elements.components.filter')

        {{-- Thông báo --}}
        @include('livewire.elements.components.alert')

        {{-- Bảng dữ liệu --}}
        @include('livewire.elements.components.table')

        {{-- Phân trang --}}
        <div class="m-6">
            {{ $data['components']->links('livewire.elements.components.paginator') }}
        </div>
    </div>

    {{-- Component style --}}
    <link rel="stylesheet" href="{{ asset('css/components/table/index.css') }}">
@endsection
