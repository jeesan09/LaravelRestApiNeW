<?php

namespace App\Http\Resources\ApiResources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return [
            'Id' => $this->id,
            'Customr_Name' => $this->customer,
            'Review' => $this->review,
            'Rating' => $this->rating,
            'Product-No' => $this->product_id,
            'User' => $this->user_id,

            'href'=>[
                'Product'=>route('products.show' ,$this->product_id)
            ]

/*'Name' => $this->name,
'Price' => $this->price,
'Descripton' => $this->detail,
'Discount' => $this->discount,
'Rating'=>$this->review_many->count() > 0 ? round($this->review_many->sum('rating')/$this->review_many->count(),1) : 'no rating Still Now',*/
        //    'created_at' => $this->created_at,
        //    'updated_at' => $this->updated_at,

          
        ];
    }
}
