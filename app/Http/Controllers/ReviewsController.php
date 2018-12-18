<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest\ReviewRequest;
use App\Http\Resources\ApiResources\ReviewsResource;
use App\Model\Product;
use App\Model\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        //
      //  return Reviews::all();
       // return 'good Job';
       return  $product->review_many;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request,Product $product)
    {
        // return $request;
       // return 'function called';
          $reviewClassOb= new Reviews;
          $reviewClassOb->product_id = $product->id;
          $reviewClassOb->customer   = $request->customer;
          $reviewClassOb->review     = $request->review; 
          $reviewClassOb->rating     = $request->rating;

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
        //
        return $review;
        
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
