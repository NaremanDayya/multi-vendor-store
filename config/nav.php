<?php
return[
    // حنبدا نعمل منيو فحنحدد شو العناصر يلي حتظهر ،كل عنصر في مصفوفة لحال
    [
        // الايقونة الخاصة بالداشبورد بنحط كلاسها
        'icon' => 'nav-icon fas fa-tachometer-alt',
        // الراوت يلي رح تنقلنا عليه
        'route' => 'dashboard.dashboard',
        // عنوان الصفحة يلي رح تنفتح
        'title' =>'Dashboard',
        'active' => 'dashboard.dashboard',
        
        
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'dashboard.categories.index',
        'title' =>'Categories',
        'badge' => 'New',
        'active' => 'dashboard.categories.*',

    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'dashboard.categories.index',
        'title' =>'Products',
        'active' => 'dashboard.products',

    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'dashboard.categories.index',
        'title' =>'Orders',
        'active' => 'dashboard.orders',
    ]
];