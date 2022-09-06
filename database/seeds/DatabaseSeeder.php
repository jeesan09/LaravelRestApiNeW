<?php

use App\Model\Product;
use App\Model\Review;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\Model\Category::class,10)->create();
        factory(App\User::class,20)->create(); 
        factory(App\Model\Product::class,50)->create();
        factory(App\Model\Review::class,300)->create();
        

// pooulate  many to many pivot tab el vaues


        // Get all the roles attaching up to 3 random roles to each user
        $catagories = App\Model\Category::all();

        // Populate the pivot table
        App\Model\Product::all()->each(function ($product) use ($catagories) { 
            $product->categorys()->attach(
                $catagories->random(rand(1, 2))->pluck('id')->toArray()
            ); 
        });


    }
}
