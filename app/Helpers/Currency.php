<?php

namespace App\Helpers;

use NumberFormatter;

class Currency
{ 
    //  عشان استدعي اسم الكلاس كانه فنكشن بنعرف ال__invoke
    public function __invoke(...$params)//عشان ابعت الباراميترز كانهم مصفوفة 
    {
        return static::format(...$params);
    } 

    public static function format($amount , $currency = null)
    {
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
        if($currency == null){
            $currency = config('app.currency', 'USD');
        }
        return $formatter->formatCurrency($amount , $currency);
    }
}