@extends('layouts.layout')
@section('title', $category->name)

@section('breadcrumb')
    @parent
    {{-- حطيناها اول عشان تظهر اول --}}
    {{-- عشان يطبق السكشن الموجود بالlayout كمان --}}
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>NAME</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        {{-- @if ($products->count()) --}}<tr>
            @php
                $products =$category->products()->with('store')->latest()->paginate(5);
            @endphp
            @forelse ($products as $pro)
                {{-- tbody>tr>td*7 --}}
                {{-- استخدمنا asset عشان يعرضلنا المسار تبع الصورة صح --}}
                {{-- عشان يوصل للمسار الصح ويطبعه صح عملناله اختصار جوا مجلد ال public للstorage  --}}
                <td><img src="{{ asset('storage/' . $pro->image) }}" alt="" height="50px"></td> 
                <td>{{ $pro->name }}</td>
                {{-- عنا هنا بدنا نستدعي الفنكشن تبعت العلاقة بينهم لكن كانها property مش فنكشن  --}}
                {{-- هنا استدعينا ال name عطول لانه اوبجكت سنجل يلي رجع مش collection  --}}
                {{-- <td>{{ $pro->category()->first()->name }}</td> --}}
                <td>{{ $pro->store->name }}</td>
                <td>{{ $pro->status }}</td>
                <td>{{ $pro->created_at }}</td>
                

        </tr>

    @empty
        <tr>
            <td colspan="5">No Products Defined</td>
        </tr>
            @endforelse
    </tbody>
</table>
 {{ $products->links() }}
@endsection
