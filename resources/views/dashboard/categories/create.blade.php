@extends('layouts.layout')
@section('title')
    Categories
@endsection
@section('breadcrumb')
    @parent
    {{-- حطيناها اول عشان تظهر اول --}}
    {{-- عشان يطبق السكشن الموجود بالlayout كمان --}}
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">

       @csrf
       @include('dashboard.categories._form' , [
        'button_label' => 'Add'
       ])
    </form>
@endsection
