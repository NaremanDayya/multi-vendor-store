<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;
    protected $fillable =[
        'order_id','type','email','street_address',
        'first_name','last_name','city','state','country',
        'postal_code','phone_number'
    ];

}
