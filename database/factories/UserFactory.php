<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Category;
use App\Product;
use App\Transaction;
use App\Seller;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'verified' => $verified = $faker->randomElement([User::UNVERIFIED_USER,User::VERIFIED_USER]),
        'verification_token' => $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(), //leh
        'admin' => $admin = $faker->randomElement([User::ADMIN_USER,User::REGULAR_USER]),

    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),

    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1,10),
        'status' => $faker->randomElement([Product::AVAILABLE_PRODUCT,Product::UNAVAILABLE_PRODUCT]),
        'image' => $faker->randomElement(['1.jpg','2.jpg','3.jpg']),
        'seller_id'=> User::all()->random()->id,
        //User::inRandomOrder()->first()->id,

    ];
});

$factory->define(Transaction::class, function (Faker $faker) {
    $seller =Seller::has('products')->get()->random(); //has method can be used to check if a key exists in the collection.
    $buyer =User::all()->except($seller->id)->random();

    return [
        'quantity' => $faker->numberBetween(1,3),
        'buyer_id'=>$buyer->id,
        'product_id'=> $seller->products->random()->id, //if there are product has been bought though the seller surely who has bought them so i want here this product id

    ];
});
