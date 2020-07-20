<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where the routes are registered for our application.
|
*/

Route::get('{path}', function () {
  return view('index');
})->where('path', '(.*)');

