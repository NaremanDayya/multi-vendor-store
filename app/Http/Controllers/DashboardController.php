<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth; 


// use Illuminate\Support\Facades\View;->لو بدي استخدم الfacade View.

class DashboardController extends Controller
{
   public function __construct(){
      // $this->middleware(['auth'])->except('index');
      // $this->middleware(['auth'])->only('index');

   $this->middleware(['auth']);

   }

    public function index()
    {
      
        $user = Auth::user();
        return view('dashboard.index', [
            'user' => $user
        ]);

        /* return response()->view('dashboard' , [
         'user' => 'alsafadi'
      ]);
      او بالكلاس
      return Response::view('dashboard' , [
         'user' => 'alsafadi'
      ]);*/

        /*return View::make('dashboard' , [
         'user' => 'alsafadi'
      ]);*/

        /* return view('dashboard' , compact('user'));
     بطريقة اخرى بعرفه كمتغير وبستدعيه باستخدام compact
     */
        /* return view('dashboard')->with([
      'user' => 'alsafadi'
   ]);
   طريقة اخرى زي compact
   */
    }
}
