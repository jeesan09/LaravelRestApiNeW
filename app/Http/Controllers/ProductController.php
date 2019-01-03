<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest\ProductRequest;
use App\Http\Resources\ApiResources\ProductResource;
use App\Http\Resources\ApiResources\ProductResourceCollection;
use App\Lib\FileUpload;
use App\Model\Product;
use App\Traits\MyAuth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use JWTAuth;

Use DB;





class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     use MyAuth;

    public function __construct()
    {
         $this->middleware('jwt.auth')->except('index','show','ProductOwner','show_Product');
         $token = JWTAuth::getToken();


         /*  if (!empty($token)) {
             $user = JWTAuth::toUser($token);
             $this->logged_user = User::find($user->id);
         } */  //this also works and porduce the same reasult

         if (!empty($token)) 
         {
             $user = JWTAuth::toUser();
             $this->logged_user = User::find($user->id);
         }
    }  

 


    public function index()
    {
          //  return $this->logged_user->id; //this is workin Perfectly;


  
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

    public function Product_of_a_user()
    {
        //
       // return $product;
    //  return  $this->Current_User_ID();


    $Current_User= $this->Current_User_ID();//Using Trait
    //$this->logged_user->id; With out useing Trait    
    $productsof=ProductResourceCollection::collection(Product::where('user_id', $Current_User)->get());
     //DB::table('products')->where('user_id', $Current_User)->get();//this quree also works
    return $productsof;

        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  return 'function called';
       // $ldate = new DateTime('now');
        //return $ldate;
      
       //return $request->all();
     //  $imgname='auto';
       if ($request->has('imag')) {
           $file = $request->file('imag');
           $imgname=sha1(time()) . '.' . $file->getClientOriginalExtension();

         // return $file->getClientOriginalName();returns original file name;
         // $request->imag->store('public/DB');//working

           $request->imag->storeAs('public/DB',$imgname);
//  Storage::putFile('public/products_image_secoend_method',$request->file('imag'));//working

          // return Storage::url($imgname);
           //return $imgname;
       }
        
      // return $imgname;

       // return $request->all();
        $productClassOB = new Product;

        $productClassOB->name        =$request->name;
        $productClassOB->price       =$request->price;
        $productClassOB->detail      =$request->detail;
        $productClassOB->discount    =$request->discount;
        $productClassOB->product_img =$imgname;
        $productClassOB->user_id     =$this->logged_user->id;

        $productClassOB->save();

      //  return $request->all(); this anly returns the the data when the request is success;

       return response([

            'data'=> new ProductResource($productClassOB)

        ], Response::HTTP_CREATED );
    }


    public function show_Product(Product $product)
    {   
        $productName = $product->product_img;

        $url=('/storage/DB/').$productName;
        return "<img src='".$url."' />";// this also woking

/*        $url=Storage::url('jeesan3.png');
        return "<img src='".$url."' />";*/// working Fine
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
       // return $request;
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

        else
        {
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
