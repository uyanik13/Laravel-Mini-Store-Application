<?php

namespace App\Http\Controllers;



use App\utils\Helpers\Helper;
use Illuminate\Http\Request;

class TestController extends Controller
{
  public function index(Request $request)
  {
    $user = auth()->setRequest($request)->user();

      Helper::DebtCheckerAndSendingNotify();


  }

}
