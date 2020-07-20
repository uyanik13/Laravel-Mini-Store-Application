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



$factory->define(App\Subscription::class, function (Faker $faker) {
  return  [
    'user_id' => '2',
    'subscription_id' => $faker->randomNumber(6),
    'user_name' => $faker->sentence(3),
    'plan_name' => 'İşletme Paketi',
    'price' =>$faker->randomNumber(2),
    'start_at' => Carbon::now()->format('d-m-Y'),
    'ends_at' => Carbon::now()->addMinutes($faker->numberBetween(1,10))->format('d-m-Y'),
    'created_at'     => Carbon::now(),
    'updated_at'     => Carbon::now(),
  ];
});
