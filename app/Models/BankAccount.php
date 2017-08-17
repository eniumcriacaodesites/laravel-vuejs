<?php

namespace CodeBills\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BankAccount extends Model implements Transformable
{
    use TransformableTrait, BelongsToTenants;

    protected $fillable = [
        'name',
        'agency',
        'account',
        'bank_id',
        'default',
        'balance',
    ];

    protected $casts = [
        'balance' => 'float',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
