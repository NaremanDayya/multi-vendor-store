<?php

namespace App\Repositories\Cart;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    protected $items;
    public function __construct()
    {
        $this->items = collect([]);//رح يحول لكولكشن عشان نستفيد من الفنكشنز تبعته
    }

    public function get(): Collection
    {
        //عشان ما نضل ننفذ الكويري كل مرة
        if(!$this->items->count())
        {
            $this->items =Cart::with('product')
            ->get();
        }
        //هنا مش حنرجع كل السلات حنرجع بس سلة اليوزر يلي عنا
        return $this->items;
        //عنا هنا استمنا هادا الشرط في كل تعاملنا مع ال cart فممكن انه نعمله ك global scope
    }

    public function add(Product $product, $quantity = 1)
    {
        $item =  Cart::where('product_id', '=', $product->id)
        ->first();
        
        if(!$item)
        {
        $cart = Cart::create([
            'user_id'   => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $quantity,

        ]);
        $this->get()->push($cart);//عشان يحدث ال items 
        return $cart;
    }
    return $item->increment('quantity', $quantity);
    }

    public function update( $id, $quantity)
    {
        Cart::where('id', '=', $id)
            ->update([
                'quantity' => $quantity,
            ]);
    }

    public function delete($id)
    {
        Cart::where('id', '=', $id) ->delete();
    }

    public function empty()
    {
        //ما بينفع نستدعيهم staticlly
        // Cart::delete();           
        // Cart::destroy();
        Cart::query()->delete();
    }

    public function total(): float
    {
    //     return (float) Cart::join('products', 'products.id', '=', 'carts.product_id')
    //         ->selectRaw('SUM(products.price * carts.quantity) as total')
    //         ->value('total'); // عشان يرجع بس قيمة التوتل بدل الاوبجكت نفسه
    // 
    //عشان احنا بدنا مجموع عملية حسابية رح نستخدم clousre function 
     return $this->get()->sum(function($item){
        return $item->quantity * $item->product->price ;
    });
}

}
