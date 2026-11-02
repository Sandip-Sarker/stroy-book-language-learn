<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    protected $fillable = [
        'plan_id',
        'feature',
    ];

    protected $casts = [
        'plan_id' => 'integer',
        'feature' => 'string',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
