<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //رح يرجع بس يلي بالراوت يلي بال body
        $products = Product::with('category:id,name','store:id,name','tags:id,name')//رجعنا ال id يلي هو الحقل الخاص بال relation 
        ->filter($request->query())
        ->paginate();//هنا رجعنا كjson لارافيل لحالها بتحول فش مشكلة
    return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:active,darft,archived',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);

           $product =  Product::create($request->all());
           //لو مسميين الفنكشن اشي غير الستور وبدي ارجع status code 201
            return response()->json($product, 201, [
                'location' => route('products.show',$product->id),
            ]);
        //    return $product;
    }   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //بعد ما عملنا resource لشكل ال response يلي بدنا اياه يرجع
        return new ProductResource($product);
        // return $product('category:id,name','store:id,name','tags:id,name');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'in:active,darft,archived',
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);

           $product->update($request->all());
           //لو مسميين الفنكشن اشي غير الستور وبدي ارجع status code 201
            return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return[
            'message' => 'product deleted!',
        ];
        // return response()->json(null,204);//no content =204
    }
}
