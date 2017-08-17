<?php

namespace CodeBills\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Subscription extends Model implements Transformable
{
    use TransformableTrait;

    const STATUS_ATIVE = 1;

    CONST STATUS_INATIVE = 2;

    protected $fillable = [
        'code',
        'user_id',
        'plan_id',
        'expires_at',
        'canceled_at',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
