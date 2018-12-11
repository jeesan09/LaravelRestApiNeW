<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Product::class, function (Faker $faker) {
    return [
        //         
            'name'=>$faker->word,
            'price'=>$faker->numberBetween(100,1000),
            'detail'=>$faker->paragraph,
            'discount'=>$faker->numberBetween(5,200)
    ];
});
