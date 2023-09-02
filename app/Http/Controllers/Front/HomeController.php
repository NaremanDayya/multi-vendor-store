<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // $products = Product::where('status' , '=', 'active');//ممكن نعمل سكوب وخلص 
        $products = Product::with('category')->active()
        ->latest()
        ->limit(8)
        ->get();
        // $products = Product::active()->latest()->take(8);

        return view('front.home', compact('products'));
    }
}


