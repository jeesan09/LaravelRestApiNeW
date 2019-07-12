<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\MyAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
     use MyAuth;

/*    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','create']]);
    }*/
    public function __construct()
    {
         $this->middleware('jwt.auth')->except('login','create');
        
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function geoLoacation($token,$email)
    {       
            $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
          //  dd($arr_ip["country"]);
             
            $User=User::where('email', $email)->first();
            $User->status = true;
            $User->country = $arr_ip["country"];
            $User->ip_address = $arr_ip["ip"];
            $User->city = $arr_ip["city"];
            $User->lat = $arr_ip["lat"];
            $User->lon = $arr_ip["lon"];
            $User->save();

            if($User->block_status==0){
               
               return $this->respondWithToken($token);
            }
            else{

               return 'Your Account has been Blocked Please contact with authority';   
            }
            
    }

    public function login(Request $request)


    {


        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return $this->geoLoacation($token,$request->email);

        
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {   
        $user=$this->Current_User_ID();
    
        $User=User::where('id', $user)->first(); 
        
        $User->status = false;
        $User->save();
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

/*    protected function validator(Request $req)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'type'   =>['required','string'],
        ]);
    }*/

    protected function create(Request $req)
    {
        //return $req;
        $validator = Validator::make($req->all(), [
            'email' => 'required|string|email|max:255|unique:users',
          //  'name' => 'required',
         //   'type'   =>['required','string'],
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

       $dataToResponse=User::create([
            'name' => $req['name'],
            'email' => $req['email'],
           // 'type'=>$req['type'],
            'password' => Hash::make($req['password']),
        ]);

       return response()->json($dataToResponse);
    }

}