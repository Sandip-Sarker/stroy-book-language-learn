<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'end_date',
        'status',
        'paypal_subscription_id',
        'paypal_order_id',
        'paypal_capture_id',
    ];

    protected $dates = ['start_date', 'end_date'];

    protected $casts = [
        'start_date'                => 'datetime',
        'end_date'                  => 'datetime',
        'user_id'                   => 'integer',
        'plan_id'                   => 'integer',
        'paypal_subscription_id'    => 'string',
        'paypal_order_id'           => 'string',
        'paypal_capture_id'         => 'string',
        'status'                    => 'string',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
