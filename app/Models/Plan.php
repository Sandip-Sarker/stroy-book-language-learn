<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    protected $fillable = [
        "name",
        "price",
        "type",
        "interval",
        "description",
        "paypal_product_id",
        "paypal_plan_id",
        "status",
    ];

    protected $casts = [
        'name'              => 'string',
        'price'             => 'decimal:2',
        'type'              => 'string',
        'interval'          => 'string',
        'description'       => 'string',
        'paypal_product_id' => 'string',
        'paypal_plan_id'    => 'string',
        'status'            => 'string',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function planFeatures()
    {
        return $this->hasMany(PlanFeature::class, 'plan_id');
    }
}
