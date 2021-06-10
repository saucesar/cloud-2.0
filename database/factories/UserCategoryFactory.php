<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserCategory;
use Faker\Generator as Faker;

$factory->define(UserCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'ram_limit' => $faker->numberBetween(100, 2000),
        'storage_limit' => $faker->numberBetween(100, 2000),
    ];
});
