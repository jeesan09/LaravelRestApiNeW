<?php

namespace App\Http\Controllers;


use App\Notifications\ResetPassword;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class PasswordResetController extends Controller
{
    //


    public function sendMail(Request $request){
          
          $emailController = $request->email;
         
         if(!$this->validateEmail($emailController)){


         	return  response()->json([

               'errot' => 'Email does Not exist'

         	], Response::HTTP_NOT_FOUND);
         	
         }

         else{
           
          //  return $this->validateEmail($emailController);
            $user=User::where('email', $emailController)->first();
            $when = now()->addSeconds(5);
         	$user->notify((new ResetPassword($user))->delay($when));

         return  response()->json([

               'response' => 'Please cheak Your Email'

         	], Response::HTTP_OK);
         }
           

         /// return $emailController;

    }

    public function validateEmail($emailController){
      
       // Product::where('user_id', $Current_User)->get()
     $User=User::where('email', $emailController)->first();
      return !!User::where('email', $emailController)->first();

/*     if(!$User){

     	//return 'false';
     }

     else{

     	return 'true';
     }*/

    }
}
