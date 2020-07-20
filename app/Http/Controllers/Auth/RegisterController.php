<?php

namespace App\Http\Controllers\Auth;

use App\Subscription;
use App\User;
use App\UserSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
  use RegistersUsers;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * The user has been registered.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\User  $user
   * @return \Illuminate\Http\JsonResponse
   */
  protected function registered(Request $request, User $user)
  {
    if ($user instanceof MustVerifyEmail) {
      $user->sendEmailVerificationNotification();

      return response()->json(['status' => trans('verification.sent')]);
    }

    return response()->json($user);
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'phone' => 'required|unique:users| min:10',
      'password' => 'required|string|min:6|confirmed',
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {

    $user_ref_number = $data['user_ref_number'] == null ? null : $data['user_ref_number'];
    $role = $data['user_ref_number'] == null ? 'store' : 'user';
    $store_ref_number = $user_ref_number == null  ? Carbon::now()->timestamp : null;
    $store_name = $data['store_name'] == null ? null : $data['store_name'] ;
    $Subscription_id    = Carbon::now()->timestamp;
    $Subscription_start = Carbon::now()->format('d-m-Y');
    $Subscription_end   = Carbon::now()->addDays(7)->format('d-m-Y');

    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'phone' => $data['phone'],
      'user_ref_number' => $user_ref_number,
      'password' => bcrypt($data['password']),
      'role' => $role
    ]);

    $userSettings = UserSetting::create([
      'user_id' => $user->id,
      'latest_invoice' => 0,
      'gift_points' => 0,
      'total_debt' => 0,
      'store_name' => $store_name,
      'store_ref_number' => $store_ref_number,
    ]);

    //IF USER STATUS === STORE
    if($role === 'store'){
      $Subscription = Subscription::create([
        'user_id' => $user->id,
        'subscription_id' => $Subscription_id,
        'user_name' => $user->name,
        'plan_name' => '7 Günlük Deneme',
        'price' => '0',
        'start_at' => $Subscription_start,
        'ends_at' => $Subscription_end
      ]);
    }

      return $user;
  }
}
