<?php

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory contains each of the model factory definitions for
| our application. Factories provide a convenient way to generate new
| model instances for testing / seeding the application's database.
|
*/

//$factory->define(App\User::class, function (Faker $faker) {
//    return [
//        'name' => $faker->name,
//        'email' => $faker->unique()->safeEmail,
//        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
//        'remember_token' => Str::random(10),
//    ];
//});

$factory->define(App\Invoice::class, function (Faker $faker) {
  return  [
    'invoice_id' => $faker->randomNumber(6),
    //'user_id' => $faker->numberBetween(3,10),
    'user_id' => '3',
    'name' => $faker->sentence(3),
    'user_name' => $faker->sentence(3),
    'user_ref_number' => '000001',
    'description' => $faker->sentence(10),
    'price' =>$faker->randomNumber(2),
    'date_of_invoice' => Carbon::now(),
    'last_date_of_invoice' => Carbon::now(),
    'status' => $faker->randomElement(['open', 'closed']),
    'created_at'     => Carbon::now(),
    'updated_at'     => Carbon::now(),
  ];
});
