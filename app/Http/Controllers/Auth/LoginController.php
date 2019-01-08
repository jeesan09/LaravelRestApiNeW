<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Socialite;
;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

//-------------Solcialite funtions------------//
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
       
         if(!$user->token){


          return 'someting is wrong';

         }

         else
         {
                 $userEmail=$user->email;
                 $userEmail_Reasult= User::where('email', '=', $userEmail)->first(); 
                 $defaute_Type='user';
                 $passward= str_random(4);

                 if(!$userEmail_Reasult)
                     {
                            $userName = $user->name;

                         return $this->sungUP_Via_Jwt($userEmail,$userName,$defaute_Type,$passward);

                        /*  $dataToResponse=User::create([
                                'name' => $user->name,
                                'email' => $user->email,
                                'type'=>$defaute_Type,
                                'password' => Hash::make($passward),
                            ]);

                           return response()->json($passward);
                                 */  //it Works
                                 
                 
                     }   
                

                else
                   {
                              return $this->loginWithGoogle_Via_Jwt($userEmail);

                   }



         }
          
        // return $user->token;

    }


       public function sungUP_Via_Jwt($userEmail,$userName,$defaute_Type,$passward){



                        $dataToResponse=User::create([
                            'name' => $userName,
                            'email' => $userEmail,
                            'type'=>$defaute_Type,
                            'password' => Hash::make($passward),
                        ]);

                       return response()->json($passward);


       }



        public function loginWithGoogle_Via_Jwt($userEmail){

                            //return $userEmail;
                            $userInfo = User::where('email', '=', $userEmail)->first();
                    
                            //return $userInfo;
                            /* $credentials = [
                                'email' => $user->email, 
                                'password' =>$userInfo->passward
                            ];*/  //currently Not working whih is but it works;
                           //$credentials;JWTAuth::fromUser($user)//JWTAuth::attempt($credentials)
                              if (! $token = JWTAuth::fromUser($userInfo)) {
                                            return response()->json(['error' => 'invalid_credentials'], 401);
                                        }

                              return $token;
                            //return $this->respondWithToken($token);

                             // return $user->email;
                              return 'user already exist';

          }




}
