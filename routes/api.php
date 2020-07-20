<?php

use Illuminate\Http\Request;




Route::group(['middleware' => 'auth:api'], function () {
 //API RESOURCES
  Route::apiResource('users', 'UserController');
  Route::apiResource('invoice', 'invoiceController');
  Route::apiResource('subscription', 'SubscriptionController');
  Route::apiResource('store', 'StoreController');


  //POST METHODS
  Route::post('logout', 'Auth\LoginController@logout');
  Route::post('updateDeviceToken', 'UserController@updateDeviceToken');
  Route::post('fetchUsersByKey', 'UserController@fetchUsersByKey');
  Route::post('fetchInvoicesByOptions', 'invoiceController@fetchInvoicesByOptions');
  Route::post('storeInvoiceFetchById', 'invoiceController@fetchInvoicesByOptionsForStore');
  Route::post('currentUserSettingsUpdate', 'SettingController@currentUserSettingsUpdate');
  Route::post('userImageUpload', 'UserController@imageUploadPost')->name('user.image.upload.post');
  Route::post('updateSetting', 'SettingController@update');
  Route::post('deleteSetting', 'SettingController@delete');
  Route::post('createPayment', 'SubscriptionController@create_payment');
  Route::post('payment_callback', 'SubscriptionController@shopier_payment_callback');


  //GET METHODS
  Route::get('fetchInvoicesById/{userId}', 'invoiceController@fetchInvoicesById');
  Route::get('fetchSettings', 'SettingController@fetch');
  Route::get('currentUserSettings', 'SettingController@currentUserSettings');
  Route::get('user', 'UserController@CurrentUser');
  Route::get('maxDebtUsers', 'UserController@maxDebtUsers');
  Route::get('test', 'TestController@index');


  //PATCH METHODS
  Route::patch('settings/profile', 'Settings\ProfileController@update');
  Route::patch('settings/password', 'Settings\PasswordController@update');

});


Route::group(['middleware' => 'guest:api'], function () {
  //POST METHODS
  Route::post('login', 'Auth\LoginController@login');
  Route::post('register', 'Auth\RegisterController@register');
  Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
  Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
  Route::post('email/resend', 'Auth\VerificationController@resend');


  //GET METHODS
  Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
  Route::get('cities', 'SettingController@getCities');



});



