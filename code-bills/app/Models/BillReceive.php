<?php

namespace CodeBills\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BillReceive extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'date_due',
        'name',
        'value',
        'done',
    ];
}
