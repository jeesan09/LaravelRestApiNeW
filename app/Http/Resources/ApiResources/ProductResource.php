<?php

namespace App\Http\Resources\ApiResources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'Product_ID' => $this->id,
            'Name' => $this->name,
            'Price' => $this->price,
            'Descripton' => $this->detail,
            'Discount' => $this->discount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
