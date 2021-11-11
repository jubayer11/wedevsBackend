<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Order::class, function (Faker $faker) {
    return [
        //
        'userId' => $faker->numberBetween(1,2),
        'billingAddress'=>$faker->address,
    ];
});
