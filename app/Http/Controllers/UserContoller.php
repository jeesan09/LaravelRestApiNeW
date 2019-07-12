<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Traits\MyAuth;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

Use DB;

class UserContoller extends Controller
{
    //
      use MyAuth;

/*    public function __construct()
    {
         $this->middleware('jwt.auth');
        
    }*/




    public function Show_all_Users()
    {

        $user=$this->Current_User();
        if (Gate::allows('admin-gate',$user) ||  Gate::allows('superAdmin-gate',$user) ) {

                  // The current user can update the post...
                 //  abort(404,"this route is also accessable for Admins");
                // return $this->Current_User_Type();              //Current_User_Type;
 
         return DB::table('users')->orderBy('created_at', 'desc')->paginate(2);
        }

        return 'this route is not allowed without Admin';

        //  return User::all();

    }



    public function update(Request $request, User $user)
    {
        //
       // return $request;
          if (Gate::allows('superAdmin-gate',$user)) {
            $user->type = $request->type;
           // $user->email = $request->email;
            

            $user->save();

          //  return $user;
            
            return response([

            'data'=> $user

            ],Response::HTTP_OK/*201*/);

           }

           return 'not Super Admin';


    }

    public function Block_status(Request $request, User $user)
    {
        //
       // return 'ok';
          if (Gate::allows('superAdmin-gate',$user)) {


            $user->block_status = $request->block_status;
           // $user->email = $request->email;
            

            $user->save();

          //  return $user;
            
            return response([

            'data'=> $user

            ],Response::HTTP_OK/*201*/);

           }

            return 'not Super Admin';


    }


  public function store(Request $request, User $user)
  {

         if (Gate::allows('admin-gate',$user) ||  Gate::allows('superAdmin-gate',$user) ) {

	        $userClassOB = new User;

	        $userClassOB->name        =$request->name;
	        $userClassOB->email       =$request->email;
	     //   $userClassOB->type        =$request->type;
	     //   $userClassOB->password    =$request->password;
          $userClassOB->password = Hash::make($request->password);
	        $userClassOB->save();


	       return response([

	            'data'=> $userClassOB

	        ], Response::HTTP_CREATED );

         }


        return 'this route is not allowed without  Admin';


  }





  public function destroy( $userd, User $user)

  {    



    

     $User=User::where('id', $userd)->first();
     
     // return $User;

     if($User){

		     if (Gate::allows('superAdmin-gate',$user)) {

		  

		            $User->delete();

		            return response([

		                'data'=> $User

		            ],Response::HTTP_ACCEPTED);

		  
		      }

		       return 'not Super Admin';





     }

     else{


           return "user doesnot exsist";

     }



       
   
   }

  public function CurrentUserType( ){


    $user=$this->Current_User_Type();
    
    return $user;

  }

  public function Shaow_all_admins(User $user,$type)

  {
       
      return $User=User::where('type', $type)->get();
  }

}
