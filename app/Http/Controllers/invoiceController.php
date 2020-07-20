<?php

namespace App\Http\Controllers;

use App\Http\Resources\invoiceCollection;
use App\Http\Resources\invoiceResource;
use App\Invoice;
use App\User;
use App\UserSetting;
use Illuminate\Http\Request;
use App\Notifications\InvoiceReminder;
use App\utils\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class invoiceController extends ApiController
{
       /**
       * Display a listing of the resource.
       *
       * @return invoiceCollection
       */
      public function index(Request $request)
  {    // Get user from $request token.

        if (!$user = auth()->setRequest($request)->user()) {
          return $this->responseUnauthorized();
        }

        $findStoreUser = UserSetting::where('user_id', $user->id)->firstOrFail();
        $storeCollection = Invoice::where('user_ref_number', $findStoreUser->store_ref_number) ;
        $userCollection = Invoice::where('user_id', $user->id) ;

        $collection = $user->role == 'store' ? $storeCollection :$userCollection;


    // Check query string filters.
    if ($status = $request->query('status')) {
      if ('open' === $status || 'closed' === $status) {
        $collection = $collection->where('status', $status);
      }
    }


    $collection = $collection->latest()->paginate();


    // Appends "status" to pagination links if present in the query.
    if ($status) {
      $collection = $collection->appends('status', $status);
    }

       return new invoiceCollection($collection);
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
        //===========================================
        // ============ VALIDATION RULES ============
        //===========================================
        $validator = Validator::make($request->all(), [
          'name' => 'required|max:255',
          'description' => 'required|max:255',
          'price' => 'required|Numeric',
          'user_id' => 'required | Integer',
        ]);
        if ($validator->fails()) {
          return $this->responseUnprocessable($validator->errors());
        }

        //===========================================
        // ===== DATE FORMATS & INVOICE USER ========
        //===========================================
        $InvoiceUser = User::where('id', $request->user_id)->firstOrFail();
         $invoice_id = Carbon::now()->timestamp;
         $date_of_invoice = Carbon::now()->format('d-m-Y');
         $last_date_of_invoice = Carbon::now()->addDays(30)->format('d-m-Y');

        //===========================================
        // ===========  INSERT DATABASE =============
        //===========================================
        try {
          $invoice = Invoice::create([
            'invoice_id' => $invoice_id,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'user_ref_number' => $InvoiceUser->user_ref_number,
            'user_name' => $InvoiceUser->name,
            'price' => $request->price,
            'date_of_invoice' => $date_of_invoice,
            'last_date_of_invoice' => $last_date_of_invoice,
          ]);

          //===========================================
          // ====== SAVE SETTINGS AND INFORMATION ====
          //===========================================
           Helper::InvoiceSaveHelper($user,$InvoiceUser,$request->price);

          //===========================================
          // ============= NOTIFICATION ===============
          //===========================================
          Helper::InvoiceNotifyHelper($invoice,$InvoiceUser);

          //===========================================
          // ================ RESPONSE ================
          //===========================================
          return response()->json(['status' => 201,'message' => 'Invoice created.', ], 201);

        } catch (\Exception $e) {
          return $this->responseServerError('Error creating Invoice.');
        }


      }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
      public function update(Request $request, $id)
      {
        //===========================================
        // ========== GET USER FROM TOKEN ===========
        //===========================================

        $user = auth()->setRequest($request)->user();
        // Get user from $request token.
        if (!$user->role == 'store' || $user->status === '0') {
          return $this->responseUnauthorized();
        }

        //===========================================
        // ============ VALIDATION RULES ============
        //===========================================

        $validator = Validator::make($request->all(), [
          'status' => 'in:closed,open',
        ]);
        if ($validator->fails()) {
          return $this->responseUnprocessable($validator->errors());
        }


        //===========================================
        // ===========  INSERT DATABASE =============
        //===========================================
        try {
            $invoice = Invoice::where('id', $id)->firstOrFail();
            if ($invoice) {
              if (request('name')) {
                $invoice->name = request('name') ? request('name') : $invoice->name ;
              }
              if (request('status')) {
                $invoice->status = request('status') ? request('status') : $invoice->status;
              }
              if (request('price')) {
                $store = UserSetting::where('user_id', $user->id)->firstOrFail();
                $InvoiceUser = User::where('id', $invoice->user_id)->firstOrFail();
                $newDebtPrice = $invoice->price >= request('price')
                  ? $store->total_debt - ($invoice->price - request('price'))
                  : $store->total_debt + (request('price') - $invoice->price);
                $store->total_debt = $request->price ?  $newDebtPrice : $store->total_debt;
                $store->save();
                $UserNewDebtPrice = $invoice->price >= request('price')
                  ? $InvoiceUser->user_total_debt - ($invoice->price - request('price'))
                  : $InvoiceUser->user_total_debt + (request('price') - $invoice->price);
                $InvoiceUser->user_total_debt = $request->price ?  $UserNewDebtPrice : $InvoiceUser->user_total_debt;
                $InvoiceUser->save();
                $invoice->price = request('price') ? request('price') : $invoice->price;
              }
              $invoice->save();



            return $this->responseResourceUpdated();
          } else {
            return $this->responseUnauthorized();
          }
        } catch (Exception $e) {
          return $this->responseServerError('Error updating resource.');
        }
      }


      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\JsonResponse
       */
      public function show(Request $request, $id)
      {

        $user = auth()->setRequest($request)->user();

        // Get user from $request token.
        if (!$user) {
          return $this->responseUnauthorized();
        }

        $invoice = Invoice::where('id', $id)
          ->orWhere('invoice_id', $id)
          ->firstOrFail();


        if (!$invoice->user_id === $user->id && !$user->role == 'admin') {
          return $this->responseUnauthorized();
        }



        return new invoiceResource($invoice);
      }

        /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */

      public function destroy(Request $request, $id)
      {
        $user = auth()->setRequest($request)->user();
        // Get user from $request token.
        if (!$user || $user->status === '0') {
          return $this->responseUnauthorized();
        }

        $invoice = Invoice::where('id', $id)->firstOrFail();

        // User can only delete their own data.
        if (!$user->role == 'admin') {
          return $this->responseUnauthorized();
        }

        try {
          $invoice->delete();

          return response()->json([
            'status' => 201,
            'message' => 'Invoice Deleted.',
          ], 201);

        } catch (Exception $e) {
          return $this->responseServerError('Error deleting resource.');
        }
      }


    /**
     * Display the specified resource.
     *
     * @return invoiceCollection
     */
    public function fetchInvoicesByOptions(Request $request)
  {

    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user || $user->status === '0') {
      return $this->responseUnauthorized();
    }



    $value = $request->searchKey;
    $invoices = Invoice::where('name', 'LIKE', '%' . $value . '%')
      ->where('user_id',$user->id )
      ->limit(25)->get();




    return new InvoiceCollection($invoices);
  }

  /**
   * Display the specified resource.
   *
   * @return invoiceCollection
   */
  public function fetchInvoicesById(Request $request,$id)
  {
    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user->role == 'store' || $user->status === '0') {
      return $this->responseUnauthorized();
    }

    $invoices = Invoice::where('user_id',$id);

    $collection = $invoices->latest()->paginate();

    return new InvoiceCollection($collection);
  }

  /**
   * Display the specified resource.
   *
   * @return invoiceCollection
   */
  public function fetchInvoicesByOptionsForStore(Request $request)
  {

    $user = auth()->setRequest($request)->user();
    // Get user from $request token.
    if (!$user->role == 'store' || $user->status === '0') {
      return $this->responseUnauthorized();
    }



    $id = $request->user_id;
    $key = $request->search_key;

    $invoices = Invoice::where('name', 'LIKE', '%' . $key . '%')
      ->where('user_id',$id)
      ->limit(25)->get();



    return new InvoiceCollection($invoices);
  }


}
