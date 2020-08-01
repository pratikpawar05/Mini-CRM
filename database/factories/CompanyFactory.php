<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->unique()->companyEmail,
        'logo'=>'company/noimagefound.png',
        'website_url' => $faker->unique()->url,
    ];
});
