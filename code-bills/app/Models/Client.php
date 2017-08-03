<?php

namespace CodeBills\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'code',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function categoryExpenses()
    {
        return $this->hasMany(CategoryExpense::class);
    }

    public function categoryRevenues()
    {
        return $this->hasMany(CategoryRevenue::class);
    }
}
