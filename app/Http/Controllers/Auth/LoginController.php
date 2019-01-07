<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Socialite;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

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
                 $defaute_Type='User';

                 if(!$userEmail_Reasult)
                 {
                        $passward= str_random(4);
                        $dataToResponse=User::create([
                            'name' => $user->name,
                            'email' => $user->email,
                            'type'=>$defaute_Type,
                            'password' => Hash::make($passward),
                        ]);

                       return response()->json($passward);
                             
                             
             
                 }   
            
    /*        $credentials = [$user->email, 'nFQvqKjM'];
           // return $credentials;
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);*/
           else
               {
                    // $userData = User::where('email', $user->email)->first();
                    // if (!$userToken=JWTAuth::fromUser($user)) {
                    //     return response()->json(['error' => 'invalid_credentials'], 401);
                    // }
                    // return "error";
                   $passward='9bHn';
                   $credentials = [
                        'email' => $user->email, 
                        'password' => $passward
                    ];
                   //$credentials;
                      if (! $token = JWTAuth::attempt($credentials)) {
                                    return response()->json(['error' => 'invalid_credentials'], 401);
                                }

                    return $token;
                    return $this->respondWithToken($token);

                     // return $user->email;
                      return 'user already exist';

               }



         }
          
        // return $user->token;

    }


}
