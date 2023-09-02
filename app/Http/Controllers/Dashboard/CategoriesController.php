<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //بدنا نعرض للparent اسمه مش id 
        // SELECT a.* FROM categories as a
        //INNER JOIN categories as b ON b.id = a.parent_id 

        // بدنا نبجا نخليه يعرض حسب الي بندخله بفورم السيرش 
        $request = request();//object
        // $request->query('name');//رح يرجع بس الاسم من ال url يلي طلبناه ،لو ما حددت الاسم بيرجعهم كلهم
        // $query = Category::query();
        //عملنا فلتر الهم عشان نختصر المساحة جوا الcontroller
        $categories = Category::with(['parent'])
         //leftJoin('categories as parents','parents.id', '=' ,'categories.parent_id')
        // ->select([
        //     'categories.*',
        //     'parents.name as parent_name'
        // ])
        //هو by default بيرجعهم كلهم بس عشان حددناله بعدها اشياء معينة بال select خلص بيرجع بس يلي حددته فبالتالي قبلها بنقله انه يرجعهم كلهم مش بس يلي تحدد بال selectRaw
        // ->select('categories.*')// ما بنفع نستخدم اكتر من select مرة وحدة فلو احتجت بنفس الاستعلام استخدم كمان مرة بنستخدم add select
        // ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count')
       // ->select(DB::raw('(SELECT COUNT(*) FROM products WHERE categry_id = categories.id) as products_count'))
       //ممكن احط جواها شروط باستخدام ال closure function 
       ->withCount([
            'products' => function($query){
                $query->where('status', '=', 'active');
            }
        ])
        //  ويعني يعدلنا الي الهم علاقة products فبنختصر ال3 اسطر يلي قبل وبيرجع عددهم بعمود اسمه )(اسم العلاقة_count) 
       ->filter($request->query())
        ->orderBy('categories.name')
        // ->withTrashed()//بترجعلي كل البيانات حتى المحدوفة
        // ->onlyTrashed()//بترجعلي فقط المحدوفة
        // ->dd();
         ->paginate();
        //$categories = Category::orderBy('name');//بردو ترتيب تصاعدي او تنازلي حسب احنا بنحددله بس by default asce
        // $categories = Category::lateste('name');//بتعرض بترتيب تنازلي حسب تاريخ الانشاء by default او بنحددلها ع اساس اي عمود ترتب
        // if($name = $request->query('name')){
        //     $query->where('name','LIKE',"%{$name}%");//لو لاقى لكلمة كجزء من الموجود رح يعرضه
        // }
        // if($status=$request->query('status')){
        // // $query->where('status','=', $status);//لو لاقى لكلمة كجزء من الموجود رح يعرضه
        // $query->whereStatus($status);//ريقة تانية بتقارن فيها اللارافيل
        // }
        // $categories = $query->paginate(2);
         // $categories = Category::archive()->paginate();//عنا هنا طبقنا الscope
        // $categories = Category::archive()->paginate();//عنا هنا طبقنا الscope
        // $categories = Category::status('active')->paginate();
        // $categories = Category::status('active')->active()->paginate(); ممكن نستدعي اكتر من scope
        //عنا هنا حددناله انه يعرض 2 مش 15 ريكورد بالصفحة، فلازم نروح بالفيو نحطله السهم للتنقل بين الصفحات
        // $categories=Category::paginate(2); //return information about pages that will be shown
        // لو بدي يعرضلي ارقام الصفحات مش بس كلمة next &previous بنستخدم سمبل 
        // $categories=Category::simplePaginate(2);
        // $categories=Category::all(); //return object from collection class and we consider it as an array
        // $categories->first();$categories[0];
        return view('dashboard.categories.index' , [
            'categories' =>$categories ,
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $parents = Category::all();
        $category= new Category();

        return view('dashboard.categories.create',compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //عنا هنا عرفنا ال validation rules جوا المودل وخلص عشان ما نكرر 
        //عنا هنا الداتا بس حترجع البيانات يلي عملنالها فاليديت مش كل بيانات الفورم فلازم نتاكد انه نعمل فاليديت لكل الحقول بالفورم
        $clean_data= $request->validate(Category::rules(), [
            // عنا هنا بنحدد كل رول شو رسالة الخطا تبعتها يلي تظهر لكل يلي الهم هادي الرول
            'required' => 'please fill this (:attribute) feild!',
            //هنا حددت انه بس لحقل الstatus
            'status.required' => 'please choose status!'

        ]);
        //بدنا نفحص اذا ارفق ملف او لا  
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]); 
        $data = $request->except('image');
       //حيخزن في ملف اسمه عشوائي داخل ل uploads
            $data['image'] =$this->uploadImage($request); 
         
        // اسهل طريقة واسرع
             
        $parents = Category::all();

        $category=Category::create($data);
      
    //PRG 'post redirect get' 
    // return Redirect::route('categories.index');
    return Redirect::route('dashboard.categories.index')
    ->with('success', "Category Created" );

    // كيف بنرجع بيانات من الفورم
        // // $request->input('name');
        // // $request->get('name')
        // // // بتشتغل مع get ,post
        // // $request->post('name');
        // // هنا ادق عشان يفهم انه بدنا القيمة يلي بال body تبع الفورم يعني يلي دخلها المستخدم
        // // $request->query('name');
        // // // بترجع القيمة من ال url
        // $request->name;
        // // $request['name'];
        // $request->all(); //بترجع كل البيانات من الفورم
        // $request->only(['name','parent_id']);//فقط هدول
        // $request->except(['name','parent_id']);//كله ما عدا هدول
    // كيف ننشئ الكاتيجوري الجديد بالداتابيز
    //اول طريقة
    //    $category= new Category();
    //    $category->name =$request->post('name');
    //    $category->parent_id =$request->post('parent_id');
    //    //......
    //    $category->save();

    // تاني طريقة
        //  $category= new Category([
        //     'name' => $request->post('name') ,
        //     'parent_id' => $request->post('parent_id'),
        //     //.....
        //  ]);
         
    //   تالت طريقة اذا انا مسمية الحقول بالفورم زي اسماء الداتابيز بتزبط وبتريحنا
        // $category = new Category($request->all());
        // $category->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show',[
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        try{
       $category = Category::findOrFail($id);
         //لحاله بيعرض 404 لو ما لقى لid 
        }
        catch(Exception $e){
            abort(404);
        }
        // select *from categories where id <> $id 
        // And (parent_id ISNULL OR <> $id) 
        //هان استثنيناه لانه بنفعش يكون ابن نفسه
         $parents = Category::where('id', '!=', $id)
         //استخدم عنا  use عشان يتعرف عال$id لانه مش جلوبل
         ->where(function($query) use($id){
                $query->whereNotNull('parent_id')
                        //وهان استثنينا انه ابنه يكون اب اله
                        ->orWhere('parent_id','!=', $id);
         })
          //وهان منعنا مشكلة انه الي ما الهم اب يكونوا زي بعض
          //يتطبعلي الsql يلي انا كتبته باستخدام الكويري
         //->dd()
         ->get();
         
        return view('dashboard.categories.edit' , compact('category' , 'parents'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        //وقفناها لانها صارت ضمنيا في الcategory request
        // $request->validate(Category::rules($id));
        $category = Category::findOrFail($id);
        // $category->update([
        //     'name' => $request->name ,
        //     //.....
        // ])
        //عنا هنا بيعمل ابديت وبيحفظ مع بعض
        $old_image=$category->image;
        $data = $request->except('image');
        //عنا هان لو جينا نعدل بيانات وما غيرنا الصورة حيعتبرها صارت null عشان هيك بناخد الباث وبنخزنه 
        // $data['image']=$this->uploadImage($request);
        $new_image=$this->uploadImage($request); 
        if($new_image){
        $data['image']= $new_image;
        }
        $category->update($data);
        
        //بدنا نقارن اذا في صورة قديمة وجددها بدنا نحدف القديمة عشان ما نزود مساحة 
        //بيعمل تعديل بدون ما يحفظ بالDB فلازم نعملsave
        // $category->fill($request->all())->save();
        if($old_image && $new_image){

            Storage::disk('public')->delete($old_image);

        }
        return Redirect::route('dashboard.categories.index')
        ->with('success', "Category $category->name Updated" );   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //model binding//بنستخدمه عطول بيغنيني عن ال findOrFail 
    // public function destroy( Category $category){
        // $category->delete();
    // }
    public function destroy($id)
    {
        //هنا خطوتين
        $category=Category::findOrFail($id);
        $category->delete();//بيحدف البيانات من ال DB لكن الاوبجكت ما زال موجود يعني الصورة لسا موجودة عادي بنحدفها بعد الديليت
        // كمان عنا ممكن الديليت ما تزبط فلو حدفت الصورة قبل ممكن ما تزبط الديليت واكون ضيعت الصورة
        //هنا وقفنا حدف الصورة عشان فعلنا السوفت ديليت فلو هو حدف الريكورد مؤقت وانا حدفت الصورة نهائي لو جيت استرجعه مش حلاقي صورته
        // if($category->image){
        //     Storage::disk('public')->delete($category->image);
        // }
        //هنا خطوة وحدة وخلص
        // Category::destroy($id);
        //another way
        // Category::where('id', '=', $id)->delete();

        return Redirect::route('dashboard.categories.index')
        ->with('success', "Category Deleted" );   
    }

    //ممكن اعرفها جوا المودل لو انا احتجتها بcontroller تاني
    protected function uploadImage(Request $request)
    {
        //دايما بنحاول نخلي ال if اقصر عشان هيك خليناها بالنفي
        if(!$request->hasFile('image')){
            return;
        }
            $file=$request->file('image');//رح ترجع فايل من كلاسuploaded file
            // $file->getClientOriginalName();//بيرجع اسم الملف زي ما هو مخزن عند المستخدم
            // $file->getSize();//بترجع حجمه بالبايت
            // $file->getClientOriginalExtension();
            // $file->getMimeType();//حيرجع امتداد الملف
            $path=$file->store('uploads', 'public');//حيخزن في ملف اسمه عشوائي داخل ل uploads
            return $path; 
        }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash' , compact('categories'));
    }    

    public function restore(Request $request , $id)
    {
        //بخليه يبحث بس جوا المحدوف 
        $categories = Category::onlyTrashed()->findOrFail($id);
        $categories->restore();
        return  redirect()->route('dashboard.categories.trash')
        ->with('success', 'Category Restored');
    }   

    public function force_delete($id)
    {
        //بخليه يبحث بس جوا المحدوف 
        $categories = Category::onlyTrashed()->findOrFail($id);
        $categories->forceDelete();
        //عنا هنا بنحدف الصورة احسن من الديليت العادية لانه هنا حدف الريكورد تماما
        if($categories->image){
            Storage::disk('public')->delete($categories->image);
        }
        return  redirect()->route('dashboard.categories.trash')
        ->with('success', 'Category deleted forever');
    }   

    }

