<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {

    }

    public function show(Product $product)
    { //هنا بتعمل access على المنتجات الctive &draft ف بنعمل فحص وخلص 
        if($product->status != 'active'){
            abort(404);
        }

        return view('front.products.show' , compact('product'));
    }
     
}
