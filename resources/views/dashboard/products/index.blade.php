@extends('layouts.layout')
@section('title')
    Products
@endsection
@section('breadcrumb')
    @parent
    {{-- حطيناها اول عشان تظهر اول --}}
    {{-- عشان يطبق السكشن الموجود بالlayout كمان --}}
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
    <div class="mb-5">
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
        {{-- <a href="{{ route('dashboard.products.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a> --}}

    </div>
    
    {{-- لو في بينهم محتوى بنحط التسكيرة لحال بنفس التاق --}}
    {{-- <x-alert>content</x-alert> --}}

    {{-- لو فش بينهم محتوى بنحط التسكيرة بنفس التاق --}}
    <x-alert type="success" />
    {{-- عنا هنا عملنا فورم للsearch  --}}
    <form action="{{ route('dashboard.products.index') }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>
        <button class"btn btn-dark mx-2">Filter</button>
    </form>
{{-- table.table>thead>tr>th*4  طريقة عشان ننشئ الجدول يلي تحت --}}
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>NAME</th>
                <th>Category</th>
                <th>Store</th>
                <th>Status</th>
                <th>Created At</th>
                <th colspan="2"></th>
                {{-- colspan"2" يعني كانها 2 من th  --}}
            </tr>
        </thead>
        <tbody>
            {{-- @if ($products->count()) --}}<tr>

                @forelse ($products as $pro)
                    {{-- tbody>tr>td*7 --}}
                    {{-- استخدمنا asset عشان يعرضلنا المسار تبع الصورة صح --}}
                    {{-- عشان يوصل للمسار الصح ويطبعه صح عملناله اختصار جوا مجلد ال public للstorage  --}}
                    <td><img src="{{ asset('storage/' . $pro->image) }}" alt="" height="50px"></td>
                    <td>{{ $pro->id }}</td>
                    <td>{{ $pro->name }}</td>
                    {{-- عنا هنا بدنا نستدعي الفنكشن تبعت العلاقة بينهم لكن كانها property مش فنكشن  --}}
                    {{-- هنا استدعينا ال name عطول لانه اوبجكت سنجل يلي رجع مش collection  --}}
                    <td>{{ $pro->category->name }}</td>
                    {{-- <td>{{ $pro->category()->first()->name }}</td> --}}
                    <td>{{ $pro->store->name }}</td>
                    <td>{{ $pro->status }}</td>
                    <td>{{ $pro->created_at }}</td>
                    <td>
                        <a href="{{ route('dashboard.products.edit', ['product' => $pro->id]) }}"
                            class="btn btn-sm btn-outline-success"> EDIT</a>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.products.destroy', ['product' => $pro->id]) }} " method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">DELETE</button>
                        </form>
                    </td>

            </tr>

        @empty
            <tr>
                <td colspan="8">No Products Defined</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    {{-- هنا حيرجع التصميم تبع الhtml يلي هما عاملينه ،لكن مش bootstrap فبدنا نزبطه --}}
    {{-- withQueryString() عشان يحافظ على الكويري والباراميترز وهو بيتنقل بين الصفحات  --}}
    {{-- appends لو بدنا نضيف باراميتر جديد على الurl  --}}
    {{-- حطينا داخل اللينك اسم الفيو يلي بدها تظهر لهادا الجزء فقط،لو بدي واجهة عامة لكل ال pagination بنروح بنحددها جوا ال Appservice Provider --}}
    {{-- {{ $products->withQueryString()->appends(['search' => 1])->links('pagination.custom')}}  --}}
    {{ $products->withQueryString()->appends(['search' => 1])->links()}} 

    @endsection

