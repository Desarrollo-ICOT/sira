<?php

use App\Models\Center;
use Faker\Generator as Faker;

$factory->define(Center::class, function (Faker $faker) {
    return [
        'code' => strtoupper($faker->unique()->lexify('????')),
    ];
});
