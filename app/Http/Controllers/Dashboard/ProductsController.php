<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //عنا هنا عملنا هادي الفكرة جوا المودل نفسه لانه حنكررها كتير فبنختصر وبنعرفها جوا المودل وبنصير نستدعيها
        // عنا هنا بدنا نخليه يعرض لكل مستخدم منتجات الستور تبعه بس
        // $user =Auth::user();
        // if($user->store_id){
        //     $products =Product::where('store_id', '=', $user->store_id)
        //     ->paginate();
        // } 
        // else{
            //بردو هنا لازم نطبقها كل مرة فبنستثنيه من المودل نفسه بنعمم الاستثناء
        $products = Product::with(['category' , 'store'])->paginate();

        //هنا عملنا foreach لانه العلاقة one-many فبيصير عنا كزا نتيجة بترجع مش سنجل
        // $category = Category::find(1);
        // foreach ($category->products as $product){
        //     echo $product->name;
        // }

        return view("dashboard.products.index" , compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $product = Product::findOrFail($id);
       
       $tags = implode(',' , $product->tags()->pluck('name')->toArray());// باستخدام العلاقة قلناله يعرض التاجز للمنتج بس ما بدي كل تفاصيله فبحددله شو بدي منها يلي هو عنا الاسم
    //حترجعلنا هيك من ال pluck فبنعمل implode وبنفصلهم بالفاصلة    [&quot;cotton&quot;,&quot;spired&quot;]
       
    return view('dashboard.products.edit', compact('product' , 'tags'));
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
        $product->update( $request->except('tags') );
        //عنا هنا رح نخزن التاجز ع شكل مصفوفة رح يصلوني وافصلهم كل ما الاقي فاصلة و بعدها رح نمر على جدول التاجز ونفحص اذا موجود خلص اذا لا بننشئ تاج جديد
        // $tags= explode(',' , $request->post('tags'));//هنا لغيناها لانه مكتبة التاجات صارت تعملها ضمنيا لكن بيظهرلي كانه json text فبدنا نجوله باستخدام json_decode
        $tags = json_decode($request->post('tags'));//هادي رح ترجعلي اوبجكت اله ارتبيوت اسمها فاليو بقيمته يلي هو اسمه
        $tag_ids=[];
        //هادي الطريقة رح تضل تعمل foreach كزا مرة ف رح تكون بتستهلك فممكن استدعي التاجز كلهم مرة وحدة قبل
        $saved_tags = Tag::all();
        foreach ($tags as $item) {
            $slug = Str::slug($item->value);
            // $tag = Tag::where('slug' , $slug)->first();
            $tag = $saved_tags->where('slug' , $slug)->first();//فهان من الكوليكشن بنبحث فيه عن التاج بدل ما نضل نبحث في الداتابيز

            if (!$tag){
                $tag = Tag::create([
                    'name' => $item->value ,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[] = $tag->id;
        }
        $product->tags()->sync($tag_ids);// وبتفحص في الجدول اذا التاج موجود في الجدول والجدول الوسيط لو لقته مش بجدول منهم بتحدفه sync بس في علاقات many-many
        // $product->tags()->attach($tag_ids);//مشكلتها انها ممكن تضيف اشي موجود لكن الداتا بيز ما حتسمجله بس بردو مش مضمونة
        // $product->tags()->detach($tag_ids);//بتحدف يلي بنضيفه للمفوفة من الجدول الوسيط بالعكس يعني
        // $product->tags()->syncWithoutDetaching($tag_ids);//بتروح بتضيف بدون ما تحدف يعني بس اضافة لو الاشي مش موجود بالجدول الوسيط فما رح نلاقي ايرور
        return redirect()->route('dashboard.products.index')
        ->with('success' , 'product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
