<?php

namespace App\View\Components;

use App\Facades\Cart;
// use App\Repositories\Cart\CartRepository;
use Illuminate\View\Component;

class CartMenu extends Component
{
    public $items;
    public $total;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    // public function __construct(CartRepository $cart)// ممكن اطلب من ال service container يمؤؤلي الاوبجكت واستخدمه
    public function __construct()
    {
        $this->items =Cart::get();
        $this->total =Cart::total();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart-menu');
    }
}
