<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest\ReviewRequest;
use App\Http\Resources\ApiResources\ProductResource;
use App\Http\Resources\ApiResources\ReviewsResource;
use App\Model\Product;
use App\Model\Review;
use App\Traits\MyAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use App\User;




class ReviewsController extends Controller
{   

    use MyAuth;

/*    public function __construct()
    {
         $this->middleware('jwt.auth')->except('index','show','ProductOwner');
         $token = JWTAuth::getToken();


           if (!empty($token)) {
             $user = JWTAuth::toUser($token);
             $this->logged_user = User::find($user->id);
         }   //this also works and porduce the same reasult

         if (!empty($token)) 
         {
             $user = JWTAuth::toUser();
             $this->logged_user = User::find($user->id);
         }
    } */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        //
        //return ReviewsResource::collection(Reviews::all());
       // return 'good Job';
        return ReviewsResource::collection($product->review_many);
       //return  $product->review_many;
    }

    public function ShowALLReviews()
    {
      // return 'functioncalled';
       return ReviewsResource::collection(Review::all());
    }


    public function ReviewBilongsto(Review $review)
    {
     /* return 'functioncalled';*/
      
    /*    $product= $review->productbelons;
        return $product->user_id;// Great from here we can get the poroducts owner information through Reviews and Products relation*/
       return new ProductResource($review->productbelons);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function MyReviews()
    {
        $Current_User= $this->Current_User_ID();//Using Trait
        //$this->logged_user->id; With out useing Trait    
        $reviewsof=ReviewsResource::collection(Review::where('user_id', $Current_User)->get());
         //DB::table('products')->where('user_id', $Current_User)->get();//this quree also works
        return $reviewsof;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request,Product $product)
    {
        // return $this->Current_User_ID();
       // return 'function called';

          $currentUser=$this->Current_User_ID();
        //  return $currentUser;

          $reviewClassOb= new Review;
          $reviewClassOb->product_id  =  $product->id;
          //$this->$currentUser;//$this->Current_User_ID()->user_id;   //$this->Current_User_ID();
          $reviewClassOb->customer    =  $request->customer;
          $reviewClassOb->review      =  $request->review; 
          $reviewClassOb->rating      =  $request->rating;
          $reviewClassOb->user_id     =  $currentUser;//$request->user_id;

          $reviewClassOb->save();


        return response([

            'data'=> new ReviewsResource($reviewClassOb)

        ], Response::HTTP_CREATED );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Review $review)
    {
          //$var=$review->productbelons
      //  return   ProductResourceCollection::collection($review->productbelons);
        return new ProductResource($review->productbelons);
        //return $review->productbelons;
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function edit(Reviews $reviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,Review $review)
    {
        //

        /* 
          return $reviews;
          return Reviews::find($reviews); //THIS IS ANTOHER SOLUTION---TO FIND THE REVIEW---THEN PARAMITERS WILL BE
          (Request $request, Product $product, $review)  LIKE THAT 

        */
          //return $review;
          $review->customer   = $request->customer;
          $review->review     = $request->review; 
          $review->rating     = $request->rating;

          $review->save();

          return response([

            'data'=> new ReviewsResource($review)

          ], Response::HTTP_OK );
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product , Review $review)
    {

         $review->delete();

         return response([

         'data'=> new ReviewsResource($review)

         ], Response::HTTP_OK );
      
    
    }
}
