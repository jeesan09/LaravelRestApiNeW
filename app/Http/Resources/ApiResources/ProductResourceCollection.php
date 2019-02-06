<?php

namespace App\Http\Resources\ApiResources;

use Illuminate\Http\Resources\Json\Resource;




class ProductResourceCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    //  return parent::toArray($request);
/*       return [

            'name' =>$request->name,
            'price' => $request->price,
            'detail' => $request->detail

       ];*/
       return [

            'Id'=>$this->id,
            'Name' => $this->name,
            'Price' => $this->price,
            'ImageUrl'=>$this->imageUrl,
          //  'Descripton' => $this->detail,
          //  'Discount' => $this->discount,
            'Rating'=>$this->review_many->count() > 0 ? round($this->review_many->sum('rating')/$this->review_many->count(),1) : 0,
        //    'created_at' => $this->created_at,
        //    'updated_at' => $this->updated_at,

            'href'=>[
                'Single-product'=>route('products.show',$this->id)
             ]
        ];

    }
}
