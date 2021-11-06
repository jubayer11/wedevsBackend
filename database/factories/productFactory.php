<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        //
        'uniqueId' => $faker->numberBetween(50000,1500000),
        'name' => $faker->name,
        'quantity' => $faker->numberBetween(1, 1000),
        'image' => 'product.png',
        'price' => $faker->numberBetween(500, 1000),
        'description' => $faker->realText(500),
    ];
});
