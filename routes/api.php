<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

  //  'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

    /*

    Route::group(['middleware' => ['jwt.auth']], function() {

       Route::apiResource('/products','ProductController');
        
    });

   */
    Route::apiResource('/products','ProductController');


    
    Route::group([ 'prefix'=>'products'],function(){

		Route::apiResource('/{product}/reviews','ReviewsController');
	  });


    Route::get('/product_owner/{product}','ProductController@ProductOwner');//Product ouwner Route 
    Route::get('/user_products','ProductController@Product_of_a_user');//Procucts of a single user

    Route::get('/ReviewID/{review}','ReviewsController@ReviewBilongsto')->name('review-of_whitch_Porduct');//particuar reviews Product
    Route::get('/allReviews','ReviewsController@ShowALLReviews');//all Reviews
    Route::get('/user_reviews','ReviewsController@MyReviews');//Reviews of single user
    













/* Route::group([ 'prefix'=>'products','middleware' => ['jwt.auth']],function(){

    Route::apiResource('/{product}/reviews','ReviewsController');
 }); // this is the way of Putting MiddleWere inside Routing*/


