<?php

namespace CodeBills\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BillReceive extends Model implements Transformable, BillRepeatTypeInterface
{
    use TransformableTrait, BelongsToTenants, BillTrait;

    protected $fillable = [
        'date_due',
        'name',
        'value',
        'done',
        'bank_account_id',
        'category_id',
    ];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryRevenue::class);
    }
}
