<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    //رح يخفي هادي البيانات من اي ريكوست من نوع json
    protected $hidden = [
        'created_at','updated_at','deleted_at','image'
    ];
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'category_id', 'store_id',
        'price', 'compare_price', 'status'
    ];
    protected $appends =[
        'image_url'
    ];//عشان يرجع مسار الصور كامل من اول البرنامج مش بس الpath

    //بنعرفها عشان نضيف اشياء خاصة بالمودل وما بنستدعيه خلص بيصير يستخدم تلقائيا لاه global scope
    protected static function booted()
    //عنا هنا مشكلة انه الادمن ما اله ستور معين يعني ما رح يعرضله اي منتج ف احنا عنا حل انه نستثنيه من هاد ال scope
    {
        //لو استخدمنا فكرة انه نعرفه في فنكشن 
        //     static::addGlobalScope('store',function(Builder $builder) {
        //         $user=Auth::user();
        //         if($user->store_id){
        //         $builder->where('store_id', '=', $user->store_id);
        //     }
        // });
        //لو بدنا نعمله كلاس ونستدعيه بنعمل كالتالي
        static::addGlobalScope('store', new StoreScope()); //اسم السكوب واسم الكلاس
            static::creating(function(Product $product){
                $product->slug = Str::slug($product->name);
            });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
        //او بستدعي namespace  المودل
        // return $this->hasMany('App\Models\Category');

    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {
        //لو انا ملتزم بالتسمية تبعت لارافيل مش رح نحتاج نحددله غير التاق كلاس
        return $this->belongsToMany(
            Tag::class,
            'product_tag', //اسم الجدول الوسيط
            'product_id', //تبع المودل يلي احنا فيه يلي هو ال product 
            'tag_id', //بنحط ال fk تبع المودل التاني يلي هو التاق
            'id', //pk تبع الجدول الحالي
            'id'
        ); //pk تبع الجدول التاني
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    //accessor
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://app.advaiet.com/item_dfile/default_product.png';
        }
        if (Str::StartsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        //عشان ما يطلعلي اعداد كبيرة بنعملله فورمات انه يظهؤ قيمة وحدة للعشري
        return number_format(100 - (100 * $this->compare_price / $this->price), 1);
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        //keys in filter override the previous array
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], function ($builder, $value) {
            $builder->where('status', $value);
        });
        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function ($builder, $value) {
            $builder->whereExists(function($query) use ($value){
                $query->select(1)
                ->from('product_tag')
                ->whereRaw('product_id = products.id')
                ->where('tag_id',$value);
            });
            // $builder->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id =?)',[$value]);
            // $builder->whereRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id =? AND product_id = products.id)',[$value]);//better performance
            // $builder->whereHas('tags', function ($builder) use ($value) {
            //     $builder->where('id', $value);
            // });
        });
    }
}
