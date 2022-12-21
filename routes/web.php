<?php

use App\Mail\Registered;
use App\Mail\SendEmailTest;
use App\Mail\SendEmailMailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Nexmo\Laravel\Facade\Nexmo;


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


//------VVI--------------------------
// Route::get('/', function () {
//     return view('welcome');
// })->middleware('User_varified_tes:admin');  // this route also work witn my custom middleware

// Route::get('/', function () {
//     return view('welcome');
// })->middleware('User_varified_tes:admin','auth'); // if you want pass variable via middleware
//------VVI--------------------------

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
/*Route::get('/showp/{product}', 'ProductController@show_Product');*/


 //------------Socialite--------//
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');


Route::get('email', function(){
 //return 'ok';
 //Mail::to('jeesan09iub@gmail.com')->send(new SendEmailMailable());
  Mail::to('jeesan09iub@gmail.com')->send(new Registered());

   Mail::to('jeesan09iub@gmail.com')->send( new SendEmailTest());
  return 'ok';
}); //mail sending is working

//---------sending Bulk email------

Route::get('sms', function(){


  Nexmo::message()->send([
    'to'   => '+880 1772 292522',
    'from' => '+880 1772 292522',
    'text' => 'Using the facade to send a message.'
  ]);

   return 'ok';
 });

Route::get('/sendBulkEmail', 'SendBulkMailController@bulk_email_send');


