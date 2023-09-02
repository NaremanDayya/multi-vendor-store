<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // بيحطله تواريخ للانشاء والتعديل منه و بندخل بيانات للجدول باستخدام المودل تبعه  
        User::create([
            'name' => 'Nareman Suhail',
            'email' => 'nanadaya166@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '9705923456',
        ]);
        //  لو مافي للجدول مودل ممكن ندخل بيانات اله بال DB facade ،هنا ما بيحط تواريخ بيخليها null
        DB::table('users')->insert([
            'name' => 'Nareman dayya',
            'email' => 'ndaya166@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '9705954636',
        ]);
    }
}
