<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    //لو ما التزمنا بالتسمية الstandard بيلزمونا هدول المتغيرات
    const CREATED_AT = 'created_at';//لو بدنا نغير اسم الحقل في الجدول بحددله اياه
    const UPDATED_AT = 'updated_at';//لو بدنا نغير اسم الحقل في الجدول بحددله اياه


    protected $table ='stores';// لو احنا مش مسميين المودل ستاندرد فبنحددله هو لاي جدول
    
    protected $connection = 'mysql'; //لو بدي اشبكr ع اتصال تاني بحدده

    protected $primaryKey = 'id'; //لو غيرت الPK بحددله مين هو 
    
    protected $keyType = 'int';//لو الpk مش id بحددله نوعه الجديد
    //protected $fillable =[];

    public $incrementing = true;// لو الPK تبعي ما كان متزايد بحددله 
    // بس هي وكمان خاصية timestamps بتكون public

    public $timestamps= true;// اذا بدناش التايم ستامب بنقله انها فولس ومش موجودة لانه بيفرض انها موجودة دائما

    public function products(){
        return $this->hasMany(Product::class , 'store_id' ,'id');
    }
}
