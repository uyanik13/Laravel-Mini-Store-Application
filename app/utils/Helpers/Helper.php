<?php
namespace App\utils\Helpers;
use App\Notifications\InvoiceReminder;
use App\Notifications\SubscriptionReminder;
use App\Setting;
use App\Subscription;
use App\User;
use App\UserSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Helper{

  public function __construct()
  {
    $this->Helper = Helper::Class();

  }


  public static function setting($key, $default = null)
    {
      if (is_null($key)) {
        return new \App\Setting\Setting();
      }

      if (is_array($key)) {
        return \App\Setting\Setting::set($key[0], $key[1]);
      }

      $value = \App\Setting\Setting::get($key);

      return is_null($value) ? value($default) : $value;
    }



  public static function electricCalculate($user, $meterAmount)
  {
    $userSetting = UserSetting::where('user_id', $user->id)
      ->firstOrFail();
    // ============= CALCULATE =================
    $totalUsage = $userSetting->electric_static;// TOTAL USAGE FROM DB - USERS TABLE
    $key= $userSetting->city.'_electric_usage_per_price';
    $kWhPerPrice = Setting::get($key);// ELECTRIC USAGE PER PRICE FROM DB - SETTINGS TABLE
    $usage_type = 'kWh';
    $usage_amount = $meterAmount - $totalUsage;
    $price = $kWhPerPrice * ($usage_amount);
    // ============= UPDATE TOTAL USAGE =================
       UserSetting::where('user_id',$user->id)
      ->update(['electric_static' => ($totalUsage + $usage_amount)]);

    return array(
      'price' => number_format($price,2),
      'usage_amount' => $usage_amount,
      'usage_type' => $usage_type,
      'invoice_type_tr' => 'Elektrik',
      'usage_per_price' => $kWhPerPrice
    );
  }


  public static function waterCalculate($user, $meterAmount)
  {

    $userSetting = UserSetting::where('user_id', $user->id)
      ->firstOrFail();
    // ============= CALCULATE =================
    $totalUsage = $userSetting->water_static;// TOTAL USAGE FROM DB - USERS TABLE
    $key = $userSetting->city.'_water_usage_per_price';
    $m3 = Setting::get($key);// WATER USAGE PER PRICE FROM DB - SETTINGS TABLE
    $usage_type = 'm3';
    $rand = random_int(4,5);
    $usage_amount = $meterAmount - $totalUsage;
    $firstPrice = $m3 * ($usage_amount);
    $kdvInclude = ($firstPrice + $rand) + (number_format(($firstPrice + $rand) / (12.75),2));
    $price = $kdvInclude +  20 + (number_format($kdvInclude/9.25,2));
    // ============= UPDATE TOTAL USAGE =================
    UserSetting::where('user_id',$user->id)
      ->update(['water_static' => ($totalUsage + $usage_amount)]);

    return array(
      'price' => number_format($price,2),
      'usage_amount' => $usage_amount,
      'usage_type' => $usage_type,
      'invoice_type_tr' => 'Su',
      'usage_per_price' => $m3
    );
  }

  public static function gasCalculate($user, $meterAmount)
  {


    $userSetting = UserSetting::where('user_id', $user->id)
      ->firstOrFail();
    // ============= CALCULATE =================
    $totalUsage = $userSetting->gas_static;// TOTAL USAGE FROM DB - USERS TABLE
    $key= $userSetting->city.'_gas_usage_per_price';
    $kWhPerPrice = Setting::get($key);// ELECTRIC USAGE PER PRICE FROM DB - SETTINGS TABLE
    $usage_type = 'm3';
    $usage_amount = $meterAmount - $totalUsage;
    $price = $kWhPerPrice * ($usage_amount);
    $kdvPrice = $price + number_format((($price*18) / (100)),2) + 2;
    // ============= UPDATE TOTAL USAGE =================
    UserSetting::where('user_id',$user->id)
      ->update(['gas_static' => ($totalUsage + $usage_amount)]);

    return array(
      'price' => number_format($kdvPrice,2),
      'usage_amount' => $usage_amount,
      'usage_type' => $usage_type,
      'invoice_type_tr' => 'Doğalgaz',
      'usage_per_price' => $kWhPerPrice
    );
  }


  public static function InvoiceSaveHelper($Store,$InvoiceUser,$requestPrice)
  {
    // ADD TOTAL DEBT TO USER SETTING FOR  ===== STORE =======
    $StoreSettings = UserSetting::where('user_id', $Store->id)->firstOrFail();
    $StoreSettings->latest_invoice = $requestPrice;
    $StoreSettings->total_debt = $requestPrice
      ? $StoreSettings->total_debt + $requestPrice
      : $StoreSettings->total_debt;
    $StoreSettings->save();

    // ADD  DEBT TO  ===== USER =======
    $InvoiceUser->user_total_debt = $requestPrice
      ? $InvoiceUser->user_total_debt + $requestPrice
      : $InvoiceUser->user_total_debt;
    $InvoiceUser->save();

    // ADD  LATEST INVOICE TO  ===== USER =======
    $InvoiceUserSettings = UserSetting::where('user_id', $InvoiceUser->id)->firstOrFail();
    $InvoiceUserSettings->latest_invoice = $requestPrice;
    $InvoiceUserSettings->gift_points = $InvoiceUserSettings->gift_points+1;
    $InvoiceUserSettings->save();

   return true;
  }


  public static function InvoiceNotifyHelper($invoice,$InvoiceUser)
  {

     $title = $invoice['name'];
     $message = $invoice['price'].'₺ Tutarlı Alışverişiniz Bulunmaktadır.';
     $InvoiceUser->notify(new InvoiceReminder($title,$message));

    $notification_data = [
            'id' => $invoice['invoice_id']
          ];
          $recipients  = [$InvoiceUser->device_token];
          fcm()
            ->to($recipients)
            ->priority('high')
            ->timeToLive(0)
            ->data($notification_data)
            ->notification([
              'body'  => $message,
              'sound' => 'default',
              'title' => $title,
              'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
            ])
            ->send();

    return true;
  }

  public static function UserDebtNotifyHelper($user,$debt)
  {

    $amount= abs($debt);
    $message = $debt <0 ? 'Hesabınızdan ' .$amount.'₺ Düşülmüştür' : 'Hesabınıza ' .$amount.'₺ Eklenmiştir.';

    $notification_data = [
      'id' => $user['id']
    ];
    $recipients  = [$user->device_token];
    fcm()
      ->to($recipients)
      ->priority('high')
      ->timeToLive(0)
      ->data($notification_data)
      ->notification([
        'body'  => $message,
        'sound' => 'default',
        'title' => 'Borcunuzda Değişiklik Oldu!',
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
      ])
      ->send();

    return true;
  }


  public static function UserImageHelper($user,$image)
  {

    $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf

    $replace = substr($image, 0, strpos($image, ',')+1);

// find substring fro replace here eg: data:image/png;base64,

    $imageConvert = str_replace($replace, '', $image);

    $imageConvert = str_replace(' ', '+', $imageConvert);

    $imageName = 'dro_id_'.$user->id.'_'.time().'.'.$extension;

    Storage::disk('public')->put('app/public/images/users/'.$imageName, base64_decode($imageConvert));

    $imageUrl = env('APP_URL').'/storage/app/public/images/users/'.$imageName;
    $userData = User::where('id', $user->id)->firstOrFail();
    $userData->photo_url = $imageUrl ? $imageUrl : $userData->photo_url ;
    $userData->save();

    return true;
  }

  // Check Subsription And Changing Status
  public static function SubscriptionCheckerAndDeleter()
  {
    $now = Carbon::now()->format('d-m-Y');
    $endedSubscriptionsUserId = Subscription::select('user_id')->where('ends_at',$now)->get()->toarray();
    $users = User::find($endedSubscriptionsUserId);
    $Message = 'Abonelik Paketiniz Sona Ermiştir. Lütfen Yıllık Ödemenizi Gerçekleştiriniz.';
      foreach ($users as $user) {
        $userData = User::where('id', $user['id'])->firstOrFail();
        $userData->status = '0';
        $userData->save();
        //$user->notify(new SubscriptionReminder($user,$Message));
        //DB::table('subscriptions')->where('user_id',  $user['id'])->delete();
      }
    DB::table('temporary_payments')->delete();
  }



  // Check Debts And Sending Notify
  public static function DebtCheckerAndSendingNotify()
  {
    $now = Carbon::now()->format('d-m-Y');
    $Stores = DB::table('user_settings')
      ->select('user_id','store_debt_request_limit','store_ref_number')
      ->where('store_ref_number', '!=',null)
      ->where('store_name', '!=',null)
      ->where('store_debt_request_limit', '!=','0')
      ->get()->toArray();

    foreach ($Stores as $Store) {
      // FINDING EVERY STORE'S USER WHICH IS OVER DEBT'S LIMIT
      $debtOverLimitUsers = User::where('user_total_debt', '>=',$Store->store_debt_request_limit)
        ->where('user_ref_number', $Store->store_ref_number)
        ->get();
         $title   = 'Borç Limiti Aşımı'  ;
         $message = 'Bağlı olduğunuz işletmenin '.$Store->store_debt_request_limit. '₺ Limitini Aşmış Bulunuyorsunuz.Lütfen En Kısa Sürede Ödeme Yapınız.'  ;
      foreach ($debtOverLimitUsers as $debtOverLimitUser) {
           Helper::fcmNotifySender($debtOverLimitUser,$message,$title); //MOBILE NOTIFICATION
           $debtOverLimitUser->notify(new InvoiceReminder($title,$message)); //EMAIL NOTIFICATION
         }

    }


  }


  public static function fcmNotifySender($user,$message,$title)
  {
    $notification_data = ['user'=>$user->name];
    $recipients  = [$user->device_token];
    fcm()
      ->to($recipients)
      ->priority('high')
      ->timeToLive(0)
      ->data($notification_data)
      ->notification([
        'body'  => $message,
        'sound' => 'default',
        'title' => $title,
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
      ])
      ->send();

    return response()->json(['status' => 201,'message' => 'FCM NOTIFICATION SUCCESSFUL.'], 201);
  }

}










