<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Category::class, function (Faker $faker) {
    return [
        //
        'title'=>$faker->word,
    ];
});
