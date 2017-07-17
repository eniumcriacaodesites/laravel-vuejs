<?php

namespace CodeBills\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BillPay extends Model implements Transformable
{
    use TransformableTrait, BelongsToTenants;

    protected $fillable = [
        'date_due',
        'name',
        'value',
        'done',
        'bank_account_id',
        'category_id',
    ];
}
