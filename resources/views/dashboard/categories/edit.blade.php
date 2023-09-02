@extends('layouts.layout')
@section('title')
    Edit Categories
@endsection
@section('breadcrumb')
    @parent
    {{-- حطيناها اول عشان تظهر اول --}}
    {{-- عشان يطبق السكشن الموجود بالlayout كمان --}}
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Edit Category</li>

@endsection

@section('content')
    <form action="{{ route('dashboard.categories.update' , $category->id) }}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        @include('dashboard.categories._form' ,[
            'button_label' => 'Update'
        ])
    </form>
@endsection
