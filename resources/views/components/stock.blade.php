@extends('layouts.app')

@section('title', 'Danh sách còn hàng')

@section('content')
    <livewire:component-table table="component-stock" />
@endsection
