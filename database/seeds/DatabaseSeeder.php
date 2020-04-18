<?php

use App\User;
use App\Category;
use App\Product;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        $usersQuantity =100 ;
        $categoriesQuantity = 20;
        $productsQuantity = 500;
        $transactionsQuantity = 500;

        factory(User::class, $usersQuantity)->create();

        factory(Category::class, $categoriesQuantity)->create();

        factory(Product::class, $productsQuantity)->create()->each(
        	function ($product) {
                $categories = Category::all()->random(mt_rand(1, 5))->pluck('id'); 
                //The pluck helper method is used to retrieve a list of specific values from a given $array

                $product->categories()->attach($categories);
                //recieve all category that related to this specific product
                /*attach() inserts related models when working with many-to-many
                 relations and no array parameter is expected.
                 It is similar to the attach() method and it also use to attach related models.*/
        	});

        factory(Transaction::class, $transactionsQuantity)->create();

    }

 }

