<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Traits\MyAuth;

class User_checking_middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

      //    use MyAuth;
 
     

    public function handle($request, Closure $next,$role)
    {
       

       
       dd($role);
        if($request->user()->Current_User_Type() == $role ) {
             
             return $next($request);

        }else{

            return redirect('/login');
        }
        
    }
}
