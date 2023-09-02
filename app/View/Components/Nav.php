<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Nav extends Component
{
    //طالما انا عرفتها public فش داعي امررها للفيو على شكل مصفوفة
    public $items;
    public $active;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($context)
    {
        $this->items = config('nav');

        $this->active = Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {//بينحددله شو الفيو يلي رح يرجعها
        //ما في داعي لخطوة تمرير المصفوفة الا لو كان المتغير protected
        // return view('components.nav',[
        //     'items' => $this->items
        // ]);
        return view('components.nav');

    }
}
