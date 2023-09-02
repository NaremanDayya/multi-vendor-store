<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    //عنا هنا عشان اسمه مش id لحال فلازم احددله شو اسم البرايمري كولوم
    protected $primary_key = 'user_id';
    
    protected $fillable = [
        'user_id',
        'first_name', 'last_name', 'birthday','gender',
        'street_address','city', 'state', 'country','postal_code'
        ,'locale'
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id', 'id');
    }
}
