<?php

namespace CodeBills\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BillReceive extends Model implements Transformable
{
    use TransformableTrait, BelongsToTenants;

    protected $fillable = [
        'date_due',
        'name',
        'value',
        'done',
    ];
}
