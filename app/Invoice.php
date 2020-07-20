<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;



class Invoice extends Model
{    use SoftDeletes;
      use Notifiable;



    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'invoice_id',
        'name',
        'price',
        'user_ref_number',
        'user_name',
        'date_of_invoice',
        'last_date_of_invoice',
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
