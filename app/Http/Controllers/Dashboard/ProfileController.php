<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\languages;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.profile.edit', [
            'user' => $user,
            // 'countries' => Countries::getNames('ar'),//حيرجع مصفوفة اسم الدولة ورمزها وبنحطله باي لغة بدنا يرجع
            'countries' => Countries::getNames('en'),//حيرجع مصفوفة اسم الدولة ورمزها وبنحطله باي لغة بدنا يرجع
            'locales' => languages::getNames('en'),// by default "en"
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable','date' , 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required', 'string', 'size:2'],
        ]);
        $user = $request->user(); //نفس فكرة ال Auth بترجعلي اليوزر يلي عامل لوج ان
        $user->profile->fill($request->all())->save();
        return redirect()->route('dashboard.profile.edit')
        ->with('success' ,'Profile Updated');
        //الfill ما بتعمل حفظ بس بتعبي فلازم نعمل سيف
        // عنا هنا اختصرنا كل الي تحت بسطر باستخدام ال fill بدون if else
        // $profile = $user->profile;//هادي دايما حترجع اوبجكت لانه استخدمنا with default فمش رح ترجع null حتكون دايما ترو
        // if ($profile->user_id){
        //     $profile->update( $request->all() );

        // } else{
        //         // $request->merge([
        //         //     'user_id' => $user->id,
        //         // ]);
        //         // Profile::create( $request->all() );
        //         // ممكن اختصرهم باستخدام ال relation 
        //         $user->profile()->create($request->all());
        // }
    }
}
