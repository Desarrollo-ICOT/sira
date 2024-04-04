<?php

use App\Models\Device;
use App\Models\Center;
use Faker\Generator as Faker;

$factory->define(Device::class, function (Faker $faker) {
    $centerId = Center::inRandomOrder()->first()->id;

    return [
        'ip' => $faker->unique()->ipv4,
        'center_id' => $centerId,
    ];
});
