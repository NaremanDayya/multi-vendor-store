<?php

namespace App\Providers;

use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    //للتخزين
    {
        // هلقيت صار عنا متغير اسمه cart  CartModelRepositoryعبارة عن نسخة من ال
        //باسستخدام الapp facade
        // App::bind(cart',function(){
        //     return new CartModelRepository();
        // });

        $this->app->bind(CartRepository::class,function(){
            return new CartModelRepository();
            //لو بدنا نغير مصدرها بس بغير return هان وبيضل باقي الشغل بالcontroller زي ما هو
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
