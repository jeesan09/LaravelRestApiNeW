<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest\ProductRequest;
use App\Http\Resources\ApiResources\ProductResource;
use App\Http\Resources\ApiResources\ProductResourceCollection;
use App\Model\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use JWTAuth;





class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function __construct()
    {
         $this->middleware('jwt.auth')->except('index','show','ProductOwner');

         $token = JWTAuth::getToken();

         if (!empty($token)) {
             $user = JWTAuth::toUser($token);
             $this->logged_user = User::find($user->id);
         }
    }  

 


    public function index()
    {
      //  return $this->logged_user->id; //this is workin Perfectly;


      //   JWTAuth::toUser();
       // paginate(5)
      // return Product::all();// this is also working but calling the function at productResourceCollection  
     return  ProductResourceCollection::collection(Product::orderBy('created_at', 'desc')->paginate(5));// this is also working but calling the function at productResourceCollection

     //   return ProductResource::collection(Product::all());//this will call product resourece

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
    public function store(ProductRequest $request)
    {
      //  return 'function called';
       // $ldate = new DateTime('now');
        //return $ldate;
      //  return $request;


        $productClassOB = new Product;

        $productClassOB->name = $request->Name;
        $productClassOB->price = $request->Price;
        $productClassOB->detail =$request->Descripton;
        $productClassOB->discount= $request->Discount;
        $productClassOB->user_id= $this->logged_user->id;

        $productClassOB->save();

      //  return $request->all(); this anly returns the the data when the request is success;

       return response([

            'data'=> new ProductResource($productClassOB)

        ], Response::HTTP_CREATED );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        //return 'sssssssss';
       // return $product;
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }
    public function ProductOwner(Product $product)
    {
        //
        /* $var=Auth::id();
          return $var;*/
        //return $product->id;
        return $product->thisProductbelonsto;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        //return $product;
        if($product->user_id == $this->logged_user->id)
        {
            $product->name = $request->Name;
            $product->price = $request->Price;
            $product->detail =$request->Descripton;
            $product->discount= $request->Discount;
            $product->user_id= $this->logged_user->id;


            $product->save();
            return response([

                'data'=> new ProductResource($product)

            ],Response::HTTP_OK/*201*/);

        }

        else{

            return response([

                'data'=> 'This is not Yours Product'

            ],Response::HTTP_ACCEPTED/*201*/);
          }

      //  return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)

    {
        //
        if($product->user_id == $this->logged_user->id)
        {

            $product->delete();

            return response([

                'data'=> new ProductResource($product)

            ],Response::HTTP_ACCEPTED /*201*/);

        }

        else{

            return response([

                'data'=> 'This is not Yours Product'

            ],Response::HTTP_ACCEPTED/*201*/);
          }

    }
}
