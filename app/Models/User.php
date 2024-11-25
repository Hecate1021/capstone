<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',

    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'resort_id');
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id')
                    ->orWhere('receiver_id', $this->id);
    }




}
