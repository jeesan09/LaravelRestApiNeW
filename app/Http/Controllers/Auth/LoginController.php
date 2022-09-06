<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\WelcomeEmail;
use App\Mail\SendEmailMailable;
use App\Mail\User_Welcome;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
                 $userName = $user->name;
  
                 if(!$userEmail_Reasult)
                     {
                            

                      return $this->sungUP_Via_Jwt($userEmail,$userName,$defaute_Type,$passward);
                       
/*                          $dataToResponse=User::create([
                                'name' => $user->name,
                                'email' => $user->email,
                                'type'=>$defaute_Type,
                                'password' => Hash::make($passward),
                            ]);

                           return response()->json($passward);*/
                                   //it Works
                                 
                 
                     }   
                

                   else
                   {          
                      return $this->loginWithGoogle_Via_Jwt($userEmail,$passward,$userName);
                
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

                     // Mail::to($userEmail)->send(new SendEmailMailable());//normal Mail
/* $job =(new WelcomeEmail($passward,$userName,$userEmail))->delay(Carbon::now()->addSeconds(5));
 dispatch($job); */           
         //  Mail::to($userEmail)->send(new User_Welcome($passward,$userName));//now sending mail through job system
                   
           //  return response()->json($passward);
           return  $this->loginWithGoogle_Via_Jwt($userEmail,$passward,$userName);

       }



        public function loginWithGoogle_Via_Jwt($userEmail,$userPassward,$userName){
                          //  return $userPassward;
                            //return $userEmail;
                            $userInfo = User::where('email', '=', $userEmail)->first();
                            
                            //return $userInfo;
                            /* $credentials = [
                                'email' => $user->email, 
                                'password' =>$userInfo->passward
                            ];*/  //currently Not working whih is but it works;

                                           //JWTAuth::attempt($credentials)
                              if (! $token = JWTAuth::fromUser($userInfo)) {
                                            return response()->json(['error' => 'invalid_credentials'], 401);
                                        }
  
  // Mail::to($userEmail)->send(new User_Welcome($userPassward,$userName));//woking        
                             return $token;  // return token for the user
                            //return $this->respondWithToken($token);

                           //   return  $userInfo;  // this also work
                             // return 'user already exist';


          }


/*MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=jeesan09iub@gmail.com
MAIL_PASSWORD=jeesan09
MAIL_ENCRYPTION=tls*/ //realmail from server;

}
