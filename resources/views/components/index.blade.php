@extends('layouts.app')

@section('title', 'Danh sách linh kiện')

@section('content')
    <livewire:component-table table="component-index" />
@endsection
