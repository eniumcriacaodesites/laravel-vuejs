<?php

namespace CodeBills\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Order extends Model implements Transformable
{
    use TransformableTrait;

    const STATUS_PENDING = 1;

    const STATUS_PAID = 2;

    const PAYMENT_TYPE_BANK_SLIP = 1;

    const PAYMENT_TYPE_BANK_CARD = 2;

    protected $fillable = [
        'date_due',
        'payment_date',
        'subscription_id',
        'payment_type',
        'payment_url',
        'code',
        'status',
        'value',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
