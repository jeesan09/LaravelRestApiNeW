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
    Route::post('register', 'AuthController@create');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::post('RememberPassword','PasswordResetController@sendMail');
    Route::get('RememberPasswordViewPage{token}','PasswordResetController@ChangeViewPage');
    Route::post('RememberPasswordConfirmButtonClick','PasswordResetController@ChangePassword');

});
//UserContoller Routes



  Route::get('/allUsers','UserContoller@Show_all_Users'); 
  Route::get('/allAdmins/{differntUserTypes}','UserContoller@Shaow_all_admins'); 
  Route::put('/user/{user}'  , 'UserContoller@update');
  Route::post('/user/create' , 'UserContoller@store');
  Route::delete('/user/delete/{userd}' , 'UserContoller@destroy');
  Route::get('/user/type' , 'UserContoller@CurrentUserType');
  Route::put('/user/block/{user}' , 'UserContoller@Block_status');



//--------------------------------------UserContoller------------------------------------------------
//all these route is assosiate to User Login through jwt authentication

    /*
    Route::group(['middleware' => ['jwt.auth']], function() {

       Route::apiResource('/products','ProductController');
        
    });

   */ //this is only for logged in users-->this route also working perfectly.
//------------------------------------------Product-----------------------------------------------------------------

    Route::apiResource('/products','ProductController');

    Route::group([ 'prefix'=>'products',/*'middleware' =>'can:superAdmin-gate'*/],function(){

		Route::apiResource('/{product}/reviews','ReviewsController');
	  });//this route is woking prefectly with 'middleware' =>'can:superAdmin-gate'-->to set a super admin user type middlewere.


    Route::get('/product_owner/{product}','ProductController@ProductOwner');//Product ouwner Route 
    Route::get('/user_products','ProductController@Product_of_a_user');//Procucts of a single user
//=============catecory======
    Route::get('/products_category/{product}','ProductController@products_category');//catecoryies of a product
    Route::get('/showp/{product}', 'ProductController@show_Product');
//-----------------------------------------------------------------------------------------------------------------



//--------------------------------------Review---------------------------------------------------------------------   
    Route::get('/ReviewID/{review}','ReviewsController@ReviewBilongsto')->name('review-of_whitch_Porduct');//particuar reviews Product
    Route::get('/allReviews','ReviewsController@ShowALLReviews');//all Reviews

   // Route::get('/user_reviews','ReviewsController@MyReviews');

    Route::get('/user_reviews',[//'ReviewsController@MyReviews'
         'uses' => 'ReviewsController@MyReviews',
         'middleware' => 'can:superAdmin-gate',

    ]);// single user has how many reviews//also working with Router MiddleWere-->admin middlewere set to this route.

//--------------------------------------------------------------------------------------------------------------------
//---------------------------------Catecory----------------------------------------------------------------------------

    Route::get('/category_products/{catego}','CategoryController@Show_All_Products');//products of a spcific catecory
    Route::post('/category_delete/{product}','ProductController@removeCategory');//depatch category from Products
//---------------------------------Notification Routes----------------------------------------------------------------

    Route::get('/notification','NotificationController@index');   
    Route::get('/notification/database','NotificationController@DataBaseNotification'); 
    Route::get('/notification/User','NotificationController@CurrentUserNotification');
    Route::get('/notification/User/Total','NotificationController@CurrentUserTotalNotification');
    Route::get('/notification/Unread_Notification','NotificationController@CurrentUser_UnreadNotification');
    Route::get('/notification/Read_Notification','NotificationController@CurrentUser_ReadNotification');

//-------------------------------------------------------------------------------------------------------------------   

/* Route::group([ 'prefix'=>'products','middleware' => ['jwt.auth']],function(){

    Route::apiResource('/{product}/reviews','ReviewsController');
 }); // this is the way of Putting MiddleWere inside Routing*/

 //------------Socialite--------//
/*Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');*/


