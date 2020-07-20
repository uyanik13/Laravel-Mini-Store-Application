<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Setting;
use App\Settings;
use App\UserSetting;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\invoiceCollection;
use App\Http\Resources\invoiceResource;

class SettingController extends Controller
{
  public function index()
  {
    return view('setting.index');
  }

  public function store(Request $request)
  {
    $rules = Setting::getValidationRules();
    $data = $this->validate($request, $rules);

    $validSettings = array_keys($rules);

    foreach ($data as $key => $val) {
      if (in_array($key, $validSettings)) {
        Setting::add($key, $val, Setting::getDataType($key));
      }
    }

    return redirect()->back()->with('status', 'Settings has been saved.');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function fetch(Request $request)
  {
    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user && !$user->role == 'admin') {
      return $this->responseUnauthorized();
    }

        $settings = Setting::all();

    return response()->json([
      'status' => 201,
      'data' => $settings,
    ], 201);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(Request $request)
  {
            $user = auth()->setRequest($request)->user();
            // Get user from $request token.
            if (!$user && !$user->role == 'admin') {
              return $this->responseUnauthorized();
            }

          Setting::set($request->name,$request->val);

              return response()->json([
                'status' => 201,
                'setting_name' => $request->name,
                'message' => 'Setting Updated.',
              ], 201);
    }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function delete(Request $request)
  {

    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user && !$user->role == 'admin') {
      return $this->responseUnauthorized();
    }

    $setting = Setting::where('id', $request->id)->firstOrFail();
    $setting->delete();
    return response()->json([
      'status' => 201,
      'setting_id' => $request->id,
      'message' => 'Setting Deleted.',
    ], 201);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function currentUserSettings(Request $request)
  {
    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user) {
      return $this->responseUnauthorized();
    }

    $settings = UserSetting::where('user_id', $user->id)->firstOrFail();

    return $settings->toArray();
  }

  public function currentUserSettingsUpdate(Request $request)
  {
    //===========================================
    // ========== GET USER FROM TOKEN ===========
    //===========================================
    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user) {
      return $this->responseUnauthorized();
    }

    //===========================================
    // ===========  INSERT DATABASE =============
    //===========================================
    try {
      $settings = UserSetting::where('user_id', $user->id)->firstOrFail();
      if ($user->id == $settings->user_id) {
        $settings->gas_static = request('gas_static') ? request('gas_static') : $settings->gas_static ;
        $settings->electric_static = request('electric_static') ? request('electric_static') : $settings->electric_static ;
        $settings->water_static = request('water_static') ? request('water_static') : $settings->water_static ;
        $settings->save();
        return response()->json([
          'status' => 201,
          'message' => 'Resource Updated.',
        ], 201);
      } else {
        return $this->responseUnauthorized();
      }
    } catch (Exception $e) {
      return $this->responseServerError('Error updating resource.');
    }
  }

}
