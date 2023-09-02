<?php

namespace App\Repositories\Cart;

use App\Models\Product;
use Illuminate\Support\Collection;

interface CartRepository
{
    public function get() : Collection;
    //هنا حدد النوع للعنصر 
    public function add(Product $product ,$quantity= 1);
    //هنا حددناها بشكل عام اي عنصر بدو يضيفه
    // public function add($item);
    public function update($id , $quantity);

    public function delete($id);

    public function empty();//لو بده يفضي السلة

    public function total():float;
}
