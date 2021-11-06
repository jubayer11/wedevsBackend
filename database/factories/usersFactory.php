<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(\App\User::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'email' => $faker->email,
        'isStaff' => 0,
        'password' => bcrypt('password'),
        'created_at' => $faker->time(),
    ];
});
