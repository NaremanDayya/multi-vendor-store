<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class , 'index'])->name('home');
Route::get('/products', [ProductsController::class , 'index'])->name('products.index');
//عشان سمينا البارااميتر لل show product لازم نسمي الباراميتر هان للراوت بردو product عشان استخجمنا فكرة ال model binding
Route::get('/products/{product}', [ProductsController::class , 'show'])->name('products.show');
//عنا هنا الراوت رح يطبع ال id للبرودكت لكن احنا بدنا اياه يطبع اسمهع او slug فبنكتبله :slug
Route::post('/paypal/webhook', function(){
  echo 'webhook called';
});

Route::resource('cart',CartController::class);
Route::get('checkout',[CheckoutController::class,'create'])
->name('checkout');
Route::post('checkout',[CheckoutController::class,'store'])
->name('checkout.store');
Route::get('/dash',function () {
    return view('dashboard');
})
->middleware(['auth'])
->name('dash');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';

