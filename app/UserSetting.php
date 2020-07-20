<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;



class UserSetting extends Model
{    use SoftDeletes;
      use Notifiable;



    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'latest_invoice',
        'gift_points',
        'total_debt',
        'store_ref_number',
        'store_debt_request_limit',
        'store_name',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
    ];


    public function users()
    {
        return $this->belongsTo(User::Class);
    }


}
