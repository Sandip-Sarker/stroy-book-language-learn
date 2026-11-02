<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'status',
        'paypal_capture_id',
        'paypal_order_id',
        'paypal_method',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'user_id'           => 'integer',
        'paypal_capture_id' => 'string',
        'paypal_order_id'   => 'string',
        'paypal_method'     => 'string',
        'amount'            => 'float',
        'currency'          => 'string',
        'status'            => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
