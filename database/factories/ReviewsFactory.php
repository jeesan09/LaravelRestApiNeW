<?php

use App\Model\Product;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Model\Review::class, function (Faker $faker) {
    return [
        //
            'customer'=>$faker->name,
          // 'price'=>$faker->numberBetween(100,1000),
            'review'=>$faker->paragraph,
            'rating'=>$faker->numberBetween(1,5),

            'product_id' => function () 
             {
             return Product::all()->random();
             },

             'user_id' => function () 
             {
             return User::all()->random();
             }
             /*
              git Pull Origin Master(){

             	return $this->Reviews
             }
             */

             
           ];
});
