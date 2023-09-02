<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group([  
    'middleware' => ['auth', 'auth.type:super_admin,admin'],
    'as' => 'dashboard.',
    'prefix' => 'dashboard',
    'namespaces' => 'App\Http\Controllers'
], function () {

    Route::get('profile', [ProfileController::class , 'edit' ])->name('profile.edit');
    Route::patch('profile', [ProfileController::class , 'update' ])->name('profile.update');//عنا هنا استخدمنا patch لانه ما بدي احط id لو استخدمنا put لازم احطله باراميتر ال id
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // ->middleware(['auth', 'verified']) عرفته جوا ال controller
    Route::get('/categories/trash', [CategoriesController::class,'trash'])
    ->name('categories.trash');

    Route::get('/categories/create', [CategoriesController::class,'create'])
    ->name('categories.create');

    Route::get('/categories/{category}', [CategoriesController::class,'show'])
    ->name('categories.show')
    ->where('category', '\d+');// عنا هنا trash routeحطينا شرط عالباراميتر انه ديجيت عدد وطوله اي عدد مدام حطينا + فعنا منعنا التشابه بينه وبين ال 

    Route::put('/categories/{category}/restore', [CategoriesController::class,'restore'])
    ->name('categories.restore');

    Route::delete('/categories/{category}/force_delete',[CategoriesController::class,'force_delete'])
    ->name('categories.force_delete');
    
    Route::resource('/categories', CategoriesController::class)
        ->middleware(['auth']);

    Route::resource('/products', ProductsController::class)
        ->middleware(['auth']);
});
