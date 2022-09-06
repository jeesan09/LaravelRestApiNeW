<?php

namespace App\Model;

use App\Model\Category;
use App\Model\Review;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    public function review_many()

    {
    	
        return $this->hasMany(Review::class);
    }




    public function thisProductbelonsto()
    {

    	//return 'jeesan';
        return  $this->belongsTo(User::class,'user_id');
    	
    }


     public function categorys()
    {
        return $this->belongsToMany(Category::class);
    }


}
