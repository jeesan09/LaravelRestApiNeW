<?php

namespace App\Model;

use App\Model\Product;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    //
    public function productbelonsto()
    {
        return  $this->belongsTo(Product::class);
    }
}
