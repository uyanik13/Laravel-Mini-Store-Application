<?php

namespace App\Http\Controllers;
use App\Custom\ShopierApi;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SubscriptionController extends ApiController
{


  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
//      $user = auth()->setRequest($request)->user();
//      // Get user from $request token.
//      if (!$user->role == 'store' || !$user->role == 'admin') {
//        return $this->responseUnauthorized();
//      }
//      //===========================================
//      // ============ VALIDATION RULES ============
//      //===========================================
//      $validator = Validator::make($request->all(), [
//        'plan_name' => 'required|max:255',
//        'price' => 'required|Numeric',
//      ]);
//      if ($validator->fails()) {
//        return $this->responseUnprocessable($validator->errors());
//      }
//
//
//      //===========================================
//      // ===== DATE FORMATS & INVOICE USER ========
//      //===========================================
//     // $SubscriptionUser = User::where('id', $request->user_id)->firstOrFail();
//      $Subscription_id    = Carbon::now()->timestamp;
//      $Subscription_start = Carbon::now();
//      $Subscription_end   = Carbon::now()->addDays(365);
//
//
//      //===========================================
//      // ===========  INSERT DATABASE =============
//      //===========================================
//      try {
//        $Subscription = Subscription::create([
//          'user_id' => $user->id,
//          'subscription_id' => $Subscription_id,
//          'user_name' => $user->name,
//          'plan_name' => $request->plan_name,
//          'price' => $request->price,
//          'start_at' => $Subscription_start,
//          'ends_at' => $Subscription_end
//        ]);
//
//
//        //===========================================
//        // ====== SAVE SETTINGS AND INFORMATION ====
//        //===========================================
//        //Helper::InvoiceSaveHelper($user,$InvoiceUser,$request->price);
//
//        //===========================================
//        // ============= NOTIFICATION ===============
//        //===========================================
//        //Helper::InvoiceNotifyHelper($invoice,$InvoiceUser);
//
//        //===========================================
//        // ================ RESPONSE ================
//        //===========================================
//        return response()->json(['status' => 201,'message' => 'Subscription Successfull', ], 201);
//
//      } catch (\Exception $e) {
//        return $this->responseServerError('Error creating Invoice.');
//      }

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
        //
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

  public function create_payment(Request $request){

    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user->role == 'store' || !$user->role == 'admin') {
      return $this->responseUnauthorized();
    }
    //===========================================
    // ============ VALIDATION RULES ============
    //===========================================
    $validator = Validator::make($request->all(), [
      'plan_name' => 'required|max:255',
      'price' => 'required|Numeric',
    ]);
    if ($validator->fails()) {
      return $this->responseUnprocessable($validator->errors());
    }
    $shopier_api = new ShopierApi();


    $productData = array(
      "name"           => $request->plan_name,
      "amount"         => number_format((double)$request->price, 2, '.', ''),
      "extraData"      => number_format((double)$request->price, 2, '.', ''),
      "paymentChannel" => "1,2,3",
    );

    $billingPhone   = '905456134513';
    $billingAddress   = 'inkılap mah';
    $billing_city   = 'istanbul';
    $billingCountry   = 'turkiye';
    $billing_postcode   = '34768';
    $order_id   =  hash('sha256', microtime());
    $amount   =  $productData['amount'];

    $userData = array(
      "id" 		        => $user->id,
      "first_name" 		=> $user->name,
      "last_name" 		=> $user->name,
      "email" 			=> $user->email,
      "order_id"      	=> $order_id,
      "amount" 	        => $amount,
      "phone" 	        => $billingPhone,
      "address" 	        => $billingAddress,
      "city" 	            => $billing_city,
      "country" 	        => $billingCountry,
      "post_code" 	    => $billing_postcode,
    );

    $shopier_api->create_payment($userData);

    $data = array(
      "user_id" 				=> $user->id,
      "user_name" 				=> $user->name,
      "plan_name" 				=> $request->plan_name,
      "price" 	=> $request->price,
      "created_at" 	=> Carbon::now(),
      "updated_at" 	=> Carbon::now(),
    );

    DB::table('temporary_payments')->insert($data);


  }

      public function shopier_payment_callback(Request $request)
      {
        $user = auth()->setRequest($request)->user();
        // Get user from $request token.
        if (!$user->role == 'store' || !$user->role == 'admin') {
          return $this->responseUnauthorized();
        }
        //===========================================
        // ============ VALIDATION RULES ============
        //===========================================
        $validator = Validator::make($request->all(), [
          'status' => 'required',
        ]);
        if ($validator->fails()) {
          return $this->responseUnprocessable($validator->errors());
        }

        $appUrl = env('APP_URL');
        $status =  $request->status;
        $Subscription_id    = Carbon::now()->timestamp;
        $Subscription_start = Carbon::now()->format('d-m-Y');
        $Subscription_end   = Carbon::now()->addDays(365)->format('d-m-Y');
        $temporaryPayment = DB::table('temporary_payments')->where('user_id', $user->id)->latest()->first();
        $userData = User::where('id', $user->id)->firstOrFail();

        if($status == 'success' && $temporaryPayment->user_id == $user->id) {
          $Subscription = Subscription::create([
            'user_id' => $user->id,
            'subscription_id' => $Subscription_id,
            'user_name' => $user->name,
            'plan_name' => $temporaryPayment->price,
            'price' => $temporaryPayment->price,
            'start_at' => $Subscription_start,
            'ends_at' => $Subscription_end
          ]);

          $userData->status = '1';
          $userData->save();

          return header("Location: $appUrl");
        }else{
          return back()->withInput();
        }

      }

}
