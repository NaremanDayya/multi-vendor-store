<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'store_id', 'payment_method',
        'status', 'payment_status'
    ];

    protected static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        // Order::whereYear('created_at', date('Y'))->max('number');
        $number =  Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)
            ->withDefault([
                'name' => 'Guest Customer',
            ]);
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'order_items',
            'order_id',
            'product_id',
            'id',
            'id'
        )->using(OrderItem::class) //عرفناله المودل تبع pivot table بس لازم يكون المودل عامل extend pivot
            ->withPivot([
                'price', 'product_name', 'quantity', 'options'
            ]);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function  billingAddress()
    {
        //رح ترجعلنا المودل نفسه
        return $this->hasOne(OrderAddress::class,'order_id','id')
        ->where('type','billing');
        //رح ترجعلنا كولكشن واحنا بس حنرجع واحد فما في داعي الها
        // return $this->addresses()->where('type','billing');
    }

    public function  shippingAddress()
    {
        return $this->hasOne(OrderAddress::class,'order_id','id')
        ->where('type','shipping');
        // return $this->addresses()->where('type','shipping');
    }
}
