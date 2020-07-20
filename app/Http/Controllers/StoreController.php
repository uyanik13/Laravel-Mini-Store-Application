<?php

namespace App\Http\Controllers;

use App\User;
use App\UserSetting;
use http\Exception;
use Illuminate\Http\Request;

class StoreController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $user = auth()->setRequest($request)->user();
      // Get user from $request token.
      if (!$user->role == 'store') {
        return $this->responseUnauthorized();
      }

      $store = UserSetting::where('user_id', $user->id)->firstOrFail();

      return $store->toJson();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      //===========================================
      // ========== GET USER FROM TOKEN ===========
      //===========================================

      $user = auth()->setRequest($request)->user();
      // Get user from $request token.
      if (!$user->role === 'store' || $user->status === '0') {
        return $this->responseUnauthorized();
      }



      //===========================================
      // ===========  INSERT DATABASE =============
      //===========================================
      try {
        $Store = UserSetting::where('user_id', $user->id)->firstOrFail();
        if ($Store) {
          //IF AUTHENTICATED USER === USER

          $Store->store_name = request('store_name') ? request('store_name') : $Store->store_name ;
          $Store->store_debt_request_limit = request('store_debt_request_limit') ? request('store_debt_request_limit') : $Store->store_debt_request_limit ;
          $Store->save();


          return $this->responseResourceUpdated();
        } else {
          return $this->responseUnauthorized();
        }
      } catch (Exception $e) {
        return $this->responseServerError('Error updating resource.');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
