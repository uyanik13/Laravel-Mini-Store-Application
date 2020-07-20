<?php

use App\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $settings = [
        [
          'id'             => 1,
          'name'           => 'istanbul_water_usage_per_price',
          'val'           => '3.50',
          'type'           => 'string',
          'locale'           => 'en-EN',
          'created_at'     => Carbon::now(),
          'updated_at'     => Carbon::now(),
        ],
        [
          'id'             => 2,
          'name'           => 'istanbul_electric_usage_per_price',
          'val'           => '0.71',
          'type'           => 'string',
          'locale'           => 'en-EN',
          'created_at'     => Carbon::now(),
          'updated_at'     => Carbon::now(),
        ],
        [
          'id'             => 3,
          'name'           => 'istanbul_gas_usage_per_price',
          'val'           => '1.60',
          'type'           => 'string',
          'locale'           => 'en-EN',
          'created_at'     => Carbon::now(),
          'updated_at'     => Carbon::now(),
        ],

      ];
        Setting::insert($settings);
    }
}
