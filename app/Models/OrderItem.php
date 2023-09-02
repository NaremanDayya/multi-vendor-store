<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{// ما بنحتاج نعرف $fillable ,لانه بيعرف gaurded فاضية
    use HasFactory;

    protected $table = 'order_items';//لانه لارافيل رح تفترضه بالمفرد
    public $incrementing = true;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class)
        ->withDefault([
            'name' => $this->product_name
        ]);
    }

}
