<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Repositories\Cart\CartRepository;

class CartController extends Controller
{
    protected $cart;
    //يتم استدعائه قبل ال middleware ,فممكن ما يقدر يوصل ال $cart لل cookie
    public function __construct(CartRepository $cart)
    {
       $this->cart = $cart; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $repository = new CartModelRepository();
        //استخدم الservice container
        //بعد ما استخدمنا باراميتر من ال repository اختصرنا السطرين بواحد بس
        // $repository =App::make('cart');
        // $items =$repository->get();
        // $items=$cart->get();
        // return view('front.cart',[
        //     'cart' => $items,
        // ]);
        return view('front.cart',[
               'cart' => $this->cart,
        ]);

    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //فش عنا فورم ندخل منه عناصر للسلة فما في داعي لل create كلها        
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'=>['required', 'int','exists:products,id'],
            'quantity' => ['nullable','int','min:1'],
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        // $repository= new CartModelRepository();
        // $repository =App::make('cart');
        $this->cart->add($product , $request->post('quantity'));
        if($request->expectsJson()){
            return response()->json([
                'message' => 'item added to cart',
            ],201);//succes and created
        }
        return redirect()->route('cart.index')->with('success','Preduct added to cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        {
            $request->validate([
                'quantity' => ['required','int','min:1'],
            ]);
            // $repository= new CartModelRepository();
            // $repository =App::make('cart');
            $this->cart->update($id , $request->post('quantity'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //دايما بنمرر قيمة الاشي يلي من service provider بعدين يلي بيرجع من ال route
    public function destroy($id)
    {
        // $repository= new CartModelRepository();
        // $repository =App::make('cart');
        $this->cart->delete($id);
        // return response()->json([
        //     'message' => 'item deleted',
        // ]);
        //هي نفسها لانه لارافيل بتعمل auto convert
        return[
            'message' => 'item deleted',
        ];
  
    }
}
