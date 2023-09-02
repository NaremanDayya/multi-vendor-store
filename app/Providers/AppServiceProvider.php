<?php

namespace App\Providers;

use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        Validator::extend('filter', function($attribute , $value, $params){
            return ! in_array(strtolower($value) , $params);

        },"the value is prohibited");
        // عشان يستخدم البوتستراب ويتنسق الشكل مع البرنامج 
        //حتروح لارافيل تعرضلي محتوى الملف يلي عملناله publish اذا لقته ، ولو ما لقته بتروح عال vendor
        Paginator::useBootstrapFour();
        //لو بدي اياه يستخدم فيو تانية للpagination 
        // Paginator::defaultView('pagination.custom');
    }
}
