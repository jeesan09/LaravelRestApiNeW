<?php
/**
 * Created by PhpStorm.
 * User: eatl
 * Date: 4/12/18
 * Time: 4:37 PM
 */

namespace App\Traits;
use JWTAuth;

trait MyAuth
{
    public function __construct()
    {
         $this->middleware('jwt.auth');

/*         $token = JWTAuth::getToken();

         if (!empty($token)) {
             $user = JWTAuth::toUser($token);
             $this->Current_User = User::find($user->id);
         }*/
    } 

    public function Current_User_ID(){

       
        $user=JWTAuth::toUser();

        return $user->id;

    }

    public function Current_User_Type(){

       
        $user=JWTAuth::toUser();

        return $user->type;

    }

     public function Current_User(){

       
        $user=JWTAuth::toUser();

        return $user;

    }   


}