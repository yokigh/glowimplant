<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'email_verification_token', 'email_verified_at', 'username', 'password', 'datebirthday', 'job',
        'phone', 'country_id', 'state', 'city', 'address1', 'address2',
        'zipcode', 'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    public function loginSessions()
{
    return $this->hasMany(LoginSession::class);
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $lang = app()->getLocale(); // اجلب اللغة الحالية
        $this->notify(new CustomResetPassword($token, $lang));
    }
    
}
