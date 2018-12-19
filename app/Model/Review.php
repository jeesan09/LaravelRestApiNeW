<?php

namespace App\Model;

use App\Model\Product;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    public function productbelons()
    {
        return  $this->belongsTo(Product::class,'product_id');
    }

/*    public function product_blongs()
	{
	    return $this->belongsTo('App\Model\Product','id')->withDefault([
	        //'name' => 'Guest Author',
	    ]);
	}
*/
}
