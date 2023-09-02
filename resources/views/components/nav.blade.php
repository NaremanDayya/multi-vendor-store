<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @foreach ($items as $item)
        <li class="nav-item">
            {{--  عنا هنا عرض الصفحة يلي احنا فيها حسب الشرط اذا اكتف خلاها زرقة لاسم الراوت بالزبط--}}
            {{-- <a href="{{ route($item['route']) }}" class="nav-link {{ $item['route'] == $active? 'active' : '' }}" > --}}
            {{-- عنا هنا رح يعتبر انه اي راوات اسمه بيبدا بالكتف يلي عرفناه رح يخليه اكتف مثلا كل راوت الcategory  رح يفعلهم ال7 --}}
            {{-- <a href="{{ route($item['route']) }}" class="nav-link {{ Route::is($active)? 'active' : '' }}" > --}}
            {{-- عنا هنا رح يفعل بس يلي بيبدوا ب dashboard.categories --}}
            {{-- <a href="{{ route($item['route']) }}" class="nav-link {{ Route::is('dashboard.categories.*')? 'active' : '' }}" > --}}
            <a href="{{ route($item['route']) }}" class="nav-link {{ Route::is( $item['active'] )? 'active' : '' }}" >

                <i class="{{ $item['icon'] }}"></i>
                <p>
                    {{ $item['title'] }}
                    @if (isset($item['badge']))
                    <span class="right badge badge-danger">{{ $item['badge'] }}</span>
                    @endif()
                </p>
            </a>
        </li>
        @endforeach
    </ul>
</nav>
<!-- /.sidebar-menu -->
