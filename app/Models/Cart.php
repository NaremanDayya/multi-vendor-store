<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = [
        'cookie_id', 'user_id', 'product_id', 'quantity', 'options'
    ];

    //Events (observers)
    //creating ,created وupdating , updated, saving ,saved, 
    //deleting, deleted, restoring , restored , retrieved
    //حسب اذا بننشئ الاشي ولا انشاناه
    protected static function booted()
    {
        //بدنا نستخدم الايفنتس عشان ياخد من خلالهم ال uuid خلال الانشاء اله
        static::creating(function(Cart $cart){
          $cart->id = Str::uuid();
          $cart->cookie_id = $cart->getCookieId();

        });
        // static::observe(CartObserver::class);
        static::addGlobalScope('cookie_id', function(Builder $builder){
            $builder->where('cookie_id', '=',Cart::getCookieId());

        });
    }

    public static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            // كلاس في php للتعامل مع الوقت والتاريخ بطريقة اسهل carbon
            Cookie::queue('cart_id', $cookie_id, 30*24*60);//بنبعتله بالدقائق
        }
        return $cookie_id;
    }


    public function user()
    {
        return $this->belongsTo(User::class)
        ->withDefault([
            'name' => 'Anonymous',
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}
