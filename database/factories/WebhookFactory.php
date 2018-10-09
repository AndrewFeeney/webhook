<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Webhook::class, function (Faker $faker) {
    return [
        'uri' => str_slug($faker->sentence),
    ];
});
