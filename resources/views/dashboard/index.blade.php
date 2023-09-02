@extends('layouts.layout')

{{-- @section('title')
  dashboard page
@endsection --}}
@section('title', 'dashboard page')
<!-- Content Wrapper. Contains page content -->
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        content
    </div>
    <!-- /.content-wrapper -->
@endsection
<!-- Control Sidebar -->

@section('breadcrumb')
    @parent
    {{-- حطيناها اول عشان تظهر اول --}}
    {{-- عشان يطبق السكشن الموجود بالlayout كمان --}}
    <li class="breadcrumb-item active">Strater Page</li>
@endsection

{{-- @push('styles')
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
@endpush

@push('scripts')
<script src="{{ asset(' plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@endpush

@push('scripts')
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
@endpush --}}