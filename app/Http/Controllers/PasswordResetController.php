<?php

namespace App\Http\Controllers;


use App\Notifications\ResetPassword;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;



class PasswordResetController extends Controller
{
    //


    public function sendMail(Request $request){
          
            $emailController = $request->email;
         
         if(!$this->validateEmail($emailController)){


          return  $this->FailureResponse();
         	
           }

         else{
           
          //  return $this->validateEmail($emailController);
            $user=User::where('email', $emailController)->first();

           // return $user->email;

           return $this->sendEmil($user);

         }
           

         /// return $emailController;

    }

    public function validateEmail($emailController){
      
      
       $User=User::where('email', $emailController)->first();
       return !!User::where('email', $emailController)->first();

	    /*if(!$User){

	     	//return 'false';
	     }

	     else{

	     	return 'true';
	    }*/ // this Also works

    }

    public function sendEmil($user)
    {   


        $token=$this->createToken($user);
     	  
     //   return $this->SuccessResponse();
        
        $when = now()->addSeconds(5);

        $user->notify((new ResetPassword($token))->delay($when));

        


        return $this->SuccessResponse();


    	
    }

	public function createToken($user){
        
        $old_token=DB::table('password_resets')->where('email',$user->email)->value('token');

        if(!$old_token){

        $token=str_random(60);

        $this->saveToken($token,$user);
        return $token;

        }

        else{


        return $old_token;
        }




	}


	public function saveToken($token,$user){

     
     DB::table('password_resets')->insert([

           'email'=> $user->email,
           'token'=>  $token,
           'created_at'=> Carbon::now()
     ]);

     return $this->SuccessResponse();
	}

	public function SuccessResponse(){

       return response()->json([

               'response' => 'Please cheak Your Email'

         	], Response::HTTP_OK);

	}

	public function FailureResponse(){

       return response()->json([

               'errot' => 'Email does Not exist'

         	], Response::HTTP_NOT_FOUND);

	}

public function ChangeViewPage($token){

  return $token;
}

public function ChangePassword(Request $request){
      
   $emaill=$request->email;
   $token =$request->token;
   $ChangePasswordTableRow=$this->getPasswordResetRow($emaill,$token);
	 return $ChangePasswordTableRow->count()>0 ? $this->ChangePasswordConfirm($ChangePasswordTableRow,$request) :  $this->FailureResponse();
    // return $token;
}

public function getPasswordResetRow($emaill,$token){

	//$user=DB::table('password_resets')->where('email',$user->email);
      
   
     return DB::table('password_resets')->where(['email'=>$emaill,'token'=>$token])->get();


}


public function ChangePasswordConfirm($ChangePasswordTableRow,$request){
  /*$myJSON = json_encode($ChangePasswordTableRow);*/
  //return $ChangePasswordTableRow; 
    //return $ChangePasswordTableRow[0]->token;
  //return $request->password;
   $email=$ChangePasswordTableRow[0]->email;
   $token=$ChangePasswordTableRow[0]->token;

   $user= User::where('email', $ChangePasswordTableRow[0]->email)->first();
   $user->update(['password'=>bcrypt($request->password)]);
 // $user->update(['password'=>$request->password]);
 //  return $user;
/* $row= $this->getPasswordResetRow($ChangePasswordTableRow[0]->email,$ChangePasswordTableRow[0]->token);
 return $row->delete();*/
  DB::table('password_resets')->where(['email'=>$email,'token'=>$token])->delete();

  return response()->json([

               'response' => 'Your Password HasBeen Reseted'

          ], Response::HTTP_CREATED);

}



}
