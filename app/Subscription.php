<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscription extends Model
{
  use Notifiable;

  protected $guarded = [];

  public function users()
  {
    return $this->belongsTo(User::Class);
  }

}

