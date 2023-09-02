@extends('layouts.layout')
@section('title')
    Edit Products
@endsection
@section('breadcrumb')
    @parent
    {{-- حطيناها اول عشان تظهر اول --}}
    {{-- عشان يطبق السكشن الموجود بالlayout كمان --}}
    <li class="breadcrumb-item active">Products</li>
    <li class="breadcrumb-item active">Edit Product</li>

@endsection

@section('content')
    <form action="{{ route('dashboard.products.update' , $product->id) }}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        @include('dashboard.products._form' ,[
            'button_label' => 'Update'
        ])
    </form>
@endsection

