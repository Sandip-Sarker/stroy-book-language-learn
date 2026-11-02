<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'role',
        'email_verified_at',
        'is_premium',
        'subscription_type',
        'xp',
    ];


    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'email_verified_at',
        'remember_token'
    ];


    protected function casts(): array
    {
        return [
            'name'                  => 'string',
            'email'                 => 'string',
            'email_verified_at'     => 'datetime',
            'password'              => 'hashed',
            'is_premium'            => 'boolean',
            'subscription_type'     => 'string',
            'xp'                    => 'integer',
        ];
    }

    public function getAvatarAttribute($value){
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        if (request()->is('api/*') && !empty($value)) {
            return url(Storage::url($value));
        }
        return $value;
    }

}
