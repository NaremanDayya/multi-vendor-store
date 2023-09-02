<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class Category extends Model
{
    use HasFactory, SoftDeletes;
// جواها بنحدد مين الحقول يلي رح تتخزن
//white list ، في الحماية هي افضل
 protected $fillable =[
'name','slug' ,'description','image','status', 'parent_id'
    ];
//  بنحدد فيها مين الحقول يلي مش رح تتخزن او يلي ما بدي اخلي المستخدم يغيرها
//black list
// لو عنا اعمدة كتيرة ورح تاخد وقت واحنا بندخلها جوا ال fillable  ممكن اعطيه guarded فاضية وبيفهم لحاله انه الباقي كله fillable
protected $guarded =[
    'id'
]; 

// public function scopeActive(Builder $builder){
//     $builder->where('status','=', 'active');
// }

// public function scopeArchive(Builder $builder){
//     $builder->where('status','=', 'archived');
// }

public function scopeStatus(Builder $builder,$status){
    $builder->where('status','=', $status);

}

// اسم الجدول يلي رح نعرف العلاقة معه داخل الفنكشن
public function products(){
    return $this->hasMany(Product::class ,'category_id', 'id');
    //او بستدعي namespace  المودل
    // return $this->hasMany('App\Models\Product');
}

public function parent(){

    return $this->belongsTo(Category::class , 'parent_id', 'id')
    ->withDefault([
        'name' => '-' // Main Categoryلو الاوبجكت ما اله اسم يحطلنا 
    ]);//لما استدعي الاسم لو ما الها اسم بتروح بتعتبره null عشان ما يعمل مشكلة انه بستدعي اشي فاضي
}

public function child(){

    return $this->hasMany(Category::class , 'parent_id', 'id');
}


public function scopeFilter(Builder $builder, $filters)
{
    //استخدمنا when عشان نختصر حمل ال if 
   
    $builder->when($filters['name'] ?? false , function($builder , $value){
        $builder->where('categories.name','LIKE',"%($value)%");//لو لاقى لكلمة كجزء من الموجود رح يعرضه

    });
    $builder->when($filters['status'] ?? false , function($builder , $value){
        $builder->where('categories.status','=',"$value");//لو لاقى لكلمة كجزء من الموجود رح يعرضه

    });
    

    // if($filters['name'] ?? false){
    //     $builder->where('name','LIKE',"%{$filters['name']}%");//لو لاقى لكلمة كجزء من الموجود رح يعرضه
    // }
    // if($filters['status'] ?? false){
    //     $builder->where('status', '=', $filters['status']);//لو لاقى لكلمة كجزء من الموجود رح يعرضه
    // }
    
}

public static function rules($id =0 )
{

    return [
        // unique بتاخد باراميتر تالت للاشي يلي بدي اسثنيه من الفحص يعني لو بعمل تعديل حستثني الكلاس يلي بعدله لانه طبيعي يكون الاسم موجود 
            // 'name' => "required|string|min:3|max:255|unique:categories,name,$id",
            'name'=>[
                'required',
                'string',
                'min:3',
                'max:255', 
                Rule::unique('categories','name')->ignore($id),
                //بدنا نعرف rule جديدة بس ع مستوى الcategory 
                // function($attribute,$value,$fails)
                // function($attribute,$value,$fails){
                //     if (strtolower($value) == 'laravel'){
                //         $fails('this name is forbidden');
                //     }
                // },
                // new Filter(['god','laravel','html', 'bootstrap','php']),//او مصفوفة بكل الكلمات الممنوعة عادي
               ' filter:php ,laravel,html,bootstrap,php', 
            ],

            'parent_id' => [
            'nullable',
            'int',
            'exists:categories,id',
            ],
            'image' =>[
                'mimes:jpg,bmp,png' ,
                // 1024*1024 byte
                 'max:1048576',
                 'dimensions:min_width=100,min_height=100',
            ],
            'status' =>[ 'required',
            'in:active,archived'],
        ];
}
// protected function uploadImage(Request $request)
// {
//     //دايما بنحاول نخلي ال if اقصر عشان هيك خليناها بالنفي
//     if(!$request->hasFile('image')){
//         return;
//     }
//         $file=$request->file('image');//رح ترجع فايل من كلاسuploaded file
//         // $file->getClientOriginalName();//بيرجع اسم الملف زي ما هو مخزن عند المستخدم
//         // $file->getSize();//بترجع حجمه بالبايت
//         // $file->getClientOriginalExtension();
//         // $file->getMimeType();//حيرجع امتداد الملف
//         $path=$file->store('uploads', 'public');//حيخزن في ملف اسمه عشوائي داخل ل uploads
//         return $path; 
//     }
}
