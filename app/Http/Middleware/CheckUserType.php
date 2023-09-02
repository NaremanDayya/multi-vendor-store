<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    //عنا حطينا 3 نقاط قبل types عشان يصير داينمك وبياخد مصفوفة مش قيمة وحدة بس 
    public function handle(Request $request, Closure $next , ...$types)
    {
        
        $user = $request->user();
        if(!$user)
        {
            return redirect()->route('login');
        }
        if(!in_array($user->type , $types))
        {
            abort(403);
        }
        $response = $next($request);//دائما بترجع response
        $content= strtoupper($response->content());
        return $response->setContent($content);//رجعتلي كل محتوى الريسبونس كابيتال لاتر
    }
}
