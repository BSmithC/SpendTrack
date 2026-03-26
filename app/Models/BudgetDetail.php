<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetDetail extends Model
{
    protected $fillable = [
        'budget_id',
        'amount',
        'total',
        'quantity',
        'status',
    ];

    public function budget()
    {
        return $this->hasMany(Budget::class);
    }
}
