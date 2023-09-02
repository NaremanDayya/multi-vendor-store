<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'slug'
    ];

    public $timestamps = false ;//لانه انا هنا لغيتها من الجدول فلازم نقله انها التغت عشان ما يحاول يضيفه ويعطينا ايرور

    public function products()
    {
        //لو انا ملتزم بالتسمية تبعت لارافيل مش رح نحتاج نحددله غير التاق كلاس
        return $this->belongsToMany(Product::class);
        // 'product_tag',//اسم الجدول الوسيط
        // 'product_id',//تبع المودل يلي احنا فيه يلي هو ال product 
        //  'tag_id',//بنحط ال fk تبع المودل التاني يلي هو التاق
        //   'id',//pk تبع الجدول الحالي
        //   'id');//pk تبع الجدول التاني
        

    }
}
