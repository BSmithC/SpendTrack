<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
    ];
    public function Expense()
    {
        return $this->hasMany(Expense::class);
    }
}
