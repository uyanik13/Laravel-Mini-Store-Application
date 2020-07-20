<?php

namespace App;

use App\Custom\Hasher;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\VerifyEmail;
use App\Notifications\ResetPassword;


class User extends Authenticatable implements JWTSubject , MustVerifyEmail
{
  use SoftDeletes, Notifiable;

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $dates = [
    'updated_at',
    'created_at',
    'deleted_at',
    'email_verified_at',
  ];

  protected $fillable = [
    'name',
    'email',
    'phone',
    'address',
    'password',
    'device_token',
    'user_ref_number',
    'user_total_debt',
    'role',
    'status',
    'created_at',
    'updated_at',
    'deleted_at',
    'remember_token',
    'email_verified_at',
  ];



      public function scopeActive($query)
      {
        return $query->where('status',1);
      }

      public function scopeInActive($query)
      {
        return $query->where('status',0);
      }

      /**
       * Get the oauth providers.
       *
       * @return \Illuminate\Database\Eloquent\Relations\HasMany
       */
      public function oauthProviders()
      {
        return $this->hasMany(OAuthProvider::class);
      }




    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Allows us to customize the password notification email.
     * See: App/Notifications/ResetPassword.php
     *
     * @param string
     */
    public function sendPasswordResetNotification($token)
    {
        $email = $this->getEmailForPasswordReset();
        $user = $this::where('email', $email)->first();
        $this->notify(new ResetPasswordNotification($token, $user->id));
    }

  /**
   * Send the email verification notification.
   *
   * @return void
   */
  public function sendEmailVerificationNotification()
  {
    $this->notify(new VerifyEmail);
  }

  public function Invoices()
  {
    return $this->hasMany(Invoice::Class);
  }

  public function Subscriptions()
  {
    return $this->hasMany(Subscription::Class);
  }

  public function UserSetting()
  {
    return $this->hasMany(UserSetting::Class);
  }

  /**
   * Route notifications for the Nexmo channel.
   *
   * @param  \Illuminate\Notifications\Notification  $notification
   * @return string
   */
  public function routeNotificationForNexmo($notification)
  {
    return $this->phone;
  }

  public function routeNotificationForChatAPI($notification)
  {
    return $this->phone;
  }


}
