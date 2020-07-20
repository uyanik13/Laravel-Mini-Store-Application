<?php

namespace App\Http\Controllers;

use App\Http\Resources\invoiceResource;
use App\Http\Resources\UserCollection;
use App\User;
use App\UserSetting;
use App\utils\Helpers\Helper;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class UserController extends ApiController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   *
   */
  public function index(Request $request)
  {
    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user->role == 'store') {
      return $this->responseUnauthorized();
    }

    $findStoreUser = UserSetting::where('user_id', $user->id)->firstOrFail();
    $collection = User::where('user_ref_number', $findStoreUser->store_ref_number);
    $collection = $collection->latest()->orderBy('name', 'ASC')->paginate();
    return $collection->toJson();
  }


  public function store(Request $request)
  {
    //===========================================
    // ========== GET USER FROM TOKEN ===========
    //===========================================
    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user->role == 'store' || $user->status === '0') {
      return $this->responseUnauthorized();
    }

    $store = UserSetting::where('user_id',$user->id)->firstOrFail();
    //===========================================
    // ============ VALIDATION RULES ============
    //===========================================
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'phone' => 'required|unique:users| min:10',
      'user_total_debt' => 'required|integer',
      'password' => 'required|string|min:6',
    ]);
    if ($validator->fails()) {
      return $this->responseUnprocessable($validator->errors());
    }

    //===========================================
    // ===========  INSERT DATABASE =============
    //===========================================
    try {
      $userData = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'user_total_debt' => floatval($request->user_total_debt),
        'user_ref_number' => $store->store_ref_number,
        'email_verified_at' => Carbon::now(),
        'password' => bcrypt($request->password),
      ]);
       $userData->toArray();

      $userSettings = UserSetting::create([
        'user_id' => $userData->id,
        'latest_invoice' => 0,
        'gift_points' => 0,
        'total_debt' => 0,
        'store_name' => null,
        'store_ref_number' => null,
      ]);


      //===========================================
      // ================ RESPONSE ================
      //===========================================
      return response()->json([
        'status' => 201,
        'message' => 'User created.',
      ], 201);

    } catch (\Exception $e) {
      return $this->responseServerError('Error creating user.');
    }



  }






  public function update(Request $request, $id)
  {
    //===========================================
    // ========== GET USER FROM TOKEN ===========
    //===========================================

    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user || $user->status === '0') {
      return $this->responseUnauthorized();
    }


    //===========================================
    // ============ VALIDATION RULES ============
    //===========================================

    $validator = Validator::make($request->all(), [
      'name' => 'max:255',
      'address' => 'max:255',
      'phone' => ' Integer',
    ]);
    if ($validator->fails()) {
      return $this->responseUnprocessable($validator->errors());
    }

    if($request['old_password']){
      if (!Hash::check($request['old_password'], Auth::user()->password)) {
        return $this->responseServerError('The old password does not match our records.');
      }
    }

    //===========================================
    // ===========  INSERT DATABASE =============
    //===========================================
    try {
      $Store = UserSetting::where('user_id', $user->id)->firstOrFail();
      $userData = User::where('id', $id)->firstOrFail();
        if ($user) {


          //IF AUTHENTICATED USER === USER
          if ($user->id == $id) {
            $userData->name = request('name') ? request('name') : $userData->name ;
            $userData->address = request('address') ? request('address') : $userData->address ;
            $userData->device_token = request('device_token') ? request('device_token') : $userData->device_token ;
            $userData->email = request('email') ? request('email') : $userData->email ;
            $userData->phone = request('phone') ? request('phone') : $userData->phone ;
            if (request('photo_url')) {
              Helper::UserImageHelper($userData,request('photo_url'));
            }

            $userData->password = request('password') ? bcrypt(request('password')) : $userData->password ;
            $userData->save();
          }

          //IF AUTHENTICATED USER === STORE
        if($Store->store_ref_number === $userData->user_ref_number){
          if (request('user_total_debt')) {
            $Store->total_debt = $Store->total_debt + request('user_total_debt') ;
            $Store->save();
            $userData->user_total_debt = $userData->user_total_debt + request('user_total_debt');
            $userData->save();
            Helper::UserDebtNotifyHelper($userData,request('user_total_debt'));
          }
        }

          //$userData->role = request('role') ? request('role') : $userData->role ;
          //$userData->status = request('status') ? request('status') : $userData->status ;

        return $this->responseResourceUpdated();
      } else {
        return $this->responseUnauthorized();
      }
    } catch (Exception $e) {
      return $this->responseServerError('Error updating resource.');
    }
  }


  public function show(Request $request, $id)
  {

    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user) {
      return $this->responseUnauthorized();
    }

    if($user->id === $id ||$user->role === 'store' ){
      $user = User::where('id', $id)->firstOrFail();
    }



    return new invoiceResource($user);
  }


  public function destroy(Request $request, $id)
  {
    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user->role === 'admin') {
      return $this->responseUnauthorized();
    }
      $userData = User::where('id', $id)->firstOrFail();

    try {
      $userData->delete();
      return $this->responseResourceDeleted();
    } catch (Exception $e) {
      return $this->responseServerError('Error deleting resource.');
    }
  }

  public function updateDeviceToken(Request $request)
  {

    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user) {
      return $this->responseUnauthorized();
    }

    //===========================================
    // ===========  INSERT DATABASE =============
    //===========================================
    try {
      if($user){

        $userData = User::where('id', $user->id)->firstOrFail();
        $userData->device_token = request('device_token') ? request('device_token') : $userData->device_token ;
        $userData->save();

        return $this->responseResourceUpdated();
      } else {
        return $this->responseUnauthorized();
      }
    } catch (Exception $e) {
      return $this->responseServerError('Error updating resource.');
    }
  }


  public function imageUploadPost(Request $request)
  {
    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user) {
      return $this->responseUnauthorized();
    }


    $image_64 = $request->image;  // your base64 encoded
    $array = explode('.', $request->name);
    $extension = end($array);

    $imageName = 'dro_id_'.$user->id.'_'.time().'.'.$extension;
    Storage::disk('public')->put('images/users/'.$imageName, base64_decode($image_64));

     $imageUrl = env('APP_URL').'/storage/app/public/images/users/'.$imageName;
     $userData = User::where('id', $user->id)->firstOrFail();
     $userData->photo_url = $imageUrl ? $imageUrl : $userData->photo_url ;
     $userData->save();


    return response()->json([
      'status' => 201,
      'message' => 'Image Uploaded',
      'image' =>  $imageUrl,
    ], 201);

  }


  public function CurrentUser(Request $request)
  {
    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user) {
      return $this->responseUnauthorized();
    }

    if($user->role === 'user'){
      $findStoreUserSettings = UserSetting::where('user_id', $user->id)->firstOrFail();
      $Store = UserSetting::where('store_ref_number', $user->user_ref_number)->firstOrFail();
      $StoreName = $user->role == 'user'? $Store->store_name : $findStoreUserSettings->store_name ;
      return response()->json([
        'id' =>  $user->id,
        'name' =>  $user->name,
        'email' =>  $user->email,
        'address' =>  $user->address,
        'phone' =>  $user->phone,
        'photo_url' =>  $user->photo_url,
        'user_ref_number' =>  $user->user_ref_number,
        'user_total_debt' =>  $user->user_total_debt,
        'device_token' =>  $user->device_token,
        'role' =>  $user->role,
        'status' =>  $user->status,
        'latest_invoice' =>  $findStoreUserSettings->latest_invoice,
        'gift_points' =>  $findStoreUserSettings->gift_points,
        'total_debt' =>  $findStoreUserSettings->total_debt,
        'store_ref_number' =>  $findStoreUserSettings->store_ref_number,
        'store_name' =>  $StoreName
      ], 201);
    }else {

      $Store = UserSetting::where('user_id', $user->id)->firstOrFail();


      return response()->json([
        'id' =>  $user->id,
        'name' =>  $user->name,
        'email' =>  $user->email,
        'address' =>  $user->address,
        'phone' =>  $user->phone,
        'photo_url' =>  $user->photo_url,
        'user_ref_number' =>  $user->user_ref_number,
        'user_total_debt' =>  $user->user_total_debt,
        'device_token' =>  $user->device_token,
        'role' =>  $user->role,
        'status' =>  $user->status,
        'latest_invoice' =>  $Store->latest_invoice,
        'gift_points' =>  $Store->gift_points,
        'total_debt' =>  $Store->total_debt,
        'store_ref_number' =>  $Store->store_ref_number,
        'store_name' =>  $Store->store_name
      ], 201);
    }



  }


  public function maxDebtUsers(Request $request)
  {
    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user->role == 'store' || $user->status === '0') {
      return $this->responseUnauthorized();
    }

    $findStoreUser = UserSetting::where('user_id', $user->id)->firstOrFail();
    $collection = User::where('user_ref_number', $findStoreUser->store_ref_number);
    $collection = $collection->orderBy('user_total_debt','desc')->limit(5)->get();
    return $collection->toJson();
  }


  public function fetchUsersByKey(Request $request)
  {

    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user->role == 'store' || $user->status === '0') {
      return $this->responseUnauthorized();
    }

    $key = $request->search_key;

    $findStoreUser = UserSetting::where('user_id', $user->id)->firstOrFail();

    $data = User::where('name', 'LIKE', '%' . $key . '%')
      ->where('user_ref_number', $findStoreUser->store_ref_number)
      ->limit(25)->get();

    return $data->toJson();
  }

}
