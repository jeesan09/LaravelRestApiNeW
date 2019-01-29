<?php

namespace App\Model;

use App\Model\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

     public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
