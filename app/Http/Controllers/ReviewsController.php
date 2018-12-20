<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest\ReviewRequest;
use App\Http\Resources\ApiResources\ProductResource;
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
