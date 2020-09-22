<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeFilter($query, $options)
    {
        /**
         * provider filter
         */
        if (isset($options['provider'])) {
            $query->where('provider', $options['provider']);
        }

        /**
         * Status filter
         */
        if (isset($options['statusCode'])) {
            $query->where('status', $options['statusCode']);
        }

        /**
         * currency filter
         */
        if (isset($options['currency'])) {
            $query->where('currency', $options['currency']);
        }

        /**
         * amount filter
         */
        if (isset($options['balanceMin']) && isset($options['balanceMax'])) {
            $query->whereBetween('amount', [$options['balanceMin'], $options['balanceMax']]);
        }
        
        return $query;
    }
}
