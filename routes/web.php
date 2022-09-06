<?php

use App\Mail\SendEmailMailable;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
/*Route::get('/showp/{product}', 'ProductController@show_Product');*/


 //------------Socialite--------//
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');


/*Route::get('email', function(){
 //return 'ok';
 //Mail::to('jeesan09iub@gmail.com')->send(new SendEmailMailable());
  Mail::to('jeesan09iub@gmail.com')->send(new SendEmailMailable());
  return 'ok';
});*/ //mail sending is working


