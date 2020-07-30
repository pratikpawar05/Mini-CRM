<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Employee::class, function (Faker $faker) {
    $company = App\Company::pluck('id')->toArray();
    return [
        //
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'company_id' => $faker->randomElement($company),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber,
    ];
});
