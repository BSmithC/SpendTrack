<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'amount_of_payments',
        'initial',
        'total',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(BudgetDetail::class);
    }
}
