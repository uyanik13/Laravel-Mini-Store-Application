<?php

use App\UserSetting;
use Illuminate\Database\Seeder;

class UserSettingSeeder extends Seeder
{
  public function run()
  {
    $users = [
      [
        'user_id'          => 1,
        'latest_invoice'   => 0,
        'total_debt'       => 0,
        'gift_points'      => 0,
        'store_ref_number' => '000000',
        'store_name'       => null,
        'created_at'        => '2019-04-15 19:13:32',
        'updated_at'        => '2019-04-15 19:13:32',
        'deleted_at'        => null,
      ],
//      [
//        'user_id'          => 2,
//        'latest_invoice'   => 48,
//        'total_debt'       => 3188,
//        'gift_points'      => 0,
//        'store_ref_number' => '000001',
//        'store_name'       => 'DRO Marketing Test',
//        'created_at'        => '2019-04-15 19:13:32',
//        'updated_at'        => '2019-04-15 19:13:32',
//        'deleted_at'        => null,
//      ],
//      [
//        'user_id'          => 3,
//        'latest_invoice'   => 0,
//        'total_debt'       => 0,
//        'gift_points'      => 0,
//        'store_ref_number' => null,
//        'store_name'       => null,
//        'created_at'        => '2019-04-15 19:13:32',
//        'updated_at'        => '2019-04-15 19:13:32',
//        'deleted_at'        => null,
//      ],
//      [
//        'user_id'          => 4,
//        'latest_invoice'   => 0,
//        'total_debt'       => 0,
//        'gift_points'      => 0,
//        'store_ref_number' => null,
//        'store_name'       => null,
//        'created_at'        => '2019-04-15 19:13:32',
//        'updated_at'        => '2019-04-15 19:13:32',
//        'deleted_at'        => null,
//      ],
//      [
//        'user_id'          => 5,
//        'latest_invoice'   => 0,
//        'total_debt'       => 0,
//        'gift_points'      => 0,
//        'store_ref_number' => null,
//        'store_name'       => null,
//        'created_at'        => '2019-04-15 19:13:32',
//        'updated_at'        => '2019-04-15 19:13:32',
//        'deleted_at'        => null,
//      ],
//      [
//        'user_id'          => 6,
//        'latest_invoice'   => 0,
//        'total_debt'       => 0,
//        'gift_points'      => 0,
//        'store_ref_number' => null,
//        'store_name'       => null,
//        'created_at'        => '2019-04-15 19:13:32',
//        'updated_at'        => '2019-04-15 19:13:32',
//        'deleted_at'        => null,
//      ],
//      [
//        'user_id'          => 7,
//        'latest_invoice'   => 0,
//        'total_debt'       => 0,
//        'gift_points'      => 0,
//        'store_ref_number' => null,
//        'store_name'       => null,
//        'created_at'        => '2019-04-15 19:13:32',
//        'updated_at'        => '2019-04-15 19:13:32',
//        'deleted_at'        => null,
//      ],
//      [
//        'user_id'          => 8,
//        'latest_invoice'   => 0,
//        'total_debt'       => 0,
//        'gift_points'      => 0,
//        'store_ref_number' => null,
//        'store_name'       => null,
//        'created_at'        => '2019-04-15 19:13:32',
//        'updated_at'        => '2019-04-15 19:13:32',
//        'deleted_at'        => null,
//      ],
//      [
//        'user_id'          => 9,
//        'latest_invoice'   => 0,
//        'total_debt'       => 0,
//        'gift_points'      => 0,
//        'store_ref_number' => null,
//        'store_name'       => null,
//        'created_at'        => '2019-04-15 19:13:32',
//        'updated_at'        => '2019-04-15 19:13:32',
//        'deleted_at'        => null,
//      ],
//      [
//        'user_id'          => 10,
//        'latest_invoice'   => 0,
//        'total_debt'       => 0,
//        'gift_points'      => 0,
//        'store_ref_number' => null,
//        'store_name'       => null,
//        'created_at'        => '2019-04-15 19:13:32',
//        'updated_at'        => '2019-04-15 19:13:32',
//        'deleted_at'        => null,
//      ],

    ];

    UserSetting::insert($users);
  }
}
