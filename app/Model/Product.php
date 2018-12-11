<?php

namespace App\Model;

use App\Model\Reviews;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    public function review_many()

    {
      return $this->hasMany(Reviews::class);
    }
}
